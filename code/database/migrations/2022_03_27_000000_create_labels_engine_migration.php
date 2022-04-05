<?php
// Needed Libraries
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


    // Code function
    /**
     * 
     */
    return new class extends Migration
    {
        // Code Preperation
        const DB_TABLE_NAME_MAILING_LIST        = 'mailing_lists';


        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            //
            Schema::create( self::DB_TABLE_NAME_MAILING_LIST, 
                function ( Blueprint $table ) 
                {
                    $table->id();
                    $table->string('content')->unique();
                }
            );

        }
        

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            //
            Schema::dropIfExists( self::DB_TABLE_NAME_MAILING_LIST );
        }
    };
?>