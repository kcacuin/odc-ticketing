<?php

use App\Models\Ticket;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach (DB::table('tickets')->oldest('id')->cursor() as $ticket)
        {
            DB::table('rich_texts')->insert([
                'field' => 'issue',
                'body' => '<div class="trix-content"> <!--[if BLOCK]><![endif]--> ' . $ticket->issue . ' <!--[if ENDBLOCK]><![endif]--> </div>',
                'record_type' => (new Ticket())->getMorphClass(),
                'record_id' => $ticket->id,
                'created_at' => $ticket->created_at,
                'updated_at' => $ticket->updated_at,
            ]);
        }

        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('issue');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rich_texts', function (Blueprint $table) {
            //
        });
    }
};
