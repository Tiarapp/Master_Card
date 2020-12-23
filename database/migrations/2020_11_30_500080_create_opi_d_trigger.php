<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateOpiDTrigger extends Migration 
{
    public function up()
    {
        DB::unprepared("CREATE TRIGGER opi_d_trigger AFTER UPDATE
                        ON opi_d FOR EACH ROW
                        BEGIN
                                UPDATE opi_d
                                SET opi_d.kg = opi_d.pcs * opi_d_view.gram_pcs
                                WHERE OLD.id = NEW.id;
                        END
                   ");
    }
    // IF OLD.gram_pcs <> NEW.gram_pcs THEN
    public function down()
    {
        DB::statement("DROP VIEW opi_d_trigger");
    }
}