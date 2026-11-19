const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const test = require('node:test');
const vm = require('node:vm');

for (const form of ['create', 'edit', 'revisi']) {
    test(`${form}: FSC selection changes only the code marker in both branches`, () => {
        const view = fs.readFileSync(path.join(__dirname, '../../resources/views/admin/mastercard', `${form}.blade.php`), 'utf8');
        const handler = form === 'create' ? 'getKodeBarang' : 'updateKodeFsc';
        assert.ok(view.includes(`name="fsc" id="fsc" onchange="${handler}()"`));
        const start = view.indexOf(form === 'create' ? '    function getKodeBarang() {' : '    function updateKodeFsc() {');
        const end = view.indexOf('    $(".Item").ready', start);
        assert.ok(start !== -1 && end !== -1);

        const values = {
            tujuan: 'L', tipebox: 'B', flute: 'BF', tipeMc: 'B1', golongan: '001',
            koli: '05', kode: 'MC1234', revisi: '1', fsc: '0', kodeBarang: 'LEGACY',
        };
        const fields = Object.fromEntries(Object.entries(values).map(([key, value]) => [key, { value }]));
        const context = { document: { getElementById: id => fields[id] }, console };
        vm.runInNewContext(view.slice(start, end), context);
        assert.equal(fields.kodeBarang.value, 'LEGACY');

        for (const type of ['B1', 'SINGLEFACE']) {
            fields.tipeMc.value = type;
            fields.fsc.value = '0';
            context.getKodeBarang();
            const nonFsc = fields.kodeBarang.value;
            fields.fsc.value = '1';
            context.getKodeBarang();
            const fsc = fields.kodeBarang.value;
            assert.equal(nonFsc[2], 'E');
            assert.equal(fsc[2], 'F');
            assert.equal(fsc.slice(0, 2) + fsc.slice(3), nonFsc.slice(0, 2) + nonFsc.slice(3));
        }
        if (form !== 'create') {
            fields.kodeBarang.value = 'LBE.03.99.S25.78901.999';
            fields.fsc.value = '1';
            context.updateKodeFsc();
            assert.equal(fields.kodeBarang.value, 'LBF.03.99.S25.78901.999');
            fields.fsc.value = '0';
            context.updateKodeFsc();
            assert.equal(fields.kodeBarang.value, 'LBE.03.99.S25.78901.999');
        }
    });
}
