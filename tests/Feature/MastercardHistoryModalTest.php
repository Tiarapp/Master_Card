<?php

namespace Tests\Feature;

use Tests\TestCase;

class MastercardHistoryModalTest extends TestCase
{
    public function test_history_modal_renders_without_error_when_history_is_missing()
    {
        $mastercard = new \stdClass();
        $mastercard->id = 42;
        $mastercard->history = null;

        $view = view('admin.mastercard.history-modal', [
            'data' => $mastercard,
            'mastercard' => $mastercard,
        ]);

        $html = $view->render();

        $this->assertStringContainsString('Tidak ada data history', $html);
        $this->assertStringContainsString('historyModal42', $html);
    }
}
