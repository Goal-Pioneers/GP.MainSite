<?php
    // Needed Libraries
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    use App\Models\AccountModel;

    // Code function
    /**
     * 
     */
    return new class extends Migration
    {
        // Code Preperation
            // Base
        const DB_CONNECTOR = 'mysql';
        const DB_ENGINE_DEFAULT = 'InnoDB';
        
            // Table names
        const DB_TABLE_NAME_ACCOUNT_VERRIFIED_AT     = 'account_verified_at';
        const DB_TABLE_NAME_ACCOUNT_ACTIVITY_VISITS  = 'account_activity_visits';

        const DB_TABLE_NAME_FAILED_JOBS              = 'failed_jobs';
        const DB_TABLE_NAME_PASSWORD_RESET           = 'password_resets';


        
        public function up()
        {
            Schema::connection( self::DB_CONNECTOR )
                  ->create( AccountModel::DB_TABLE_NAME, 
                function ( Blueprint $table ) 
                {
                    $table->engine = self::DB_ENGINE_DEFAULT;

                    $table->id();
                    $table->string( 'username' );
                    
                    $table->bigInteger( 'email_id' )
                          ->unsigned()
                          ->unique();

                    $table->string( 'password' );

                    $table->rememberToken();
                    
                    $table->foreign( 'email_id' )
                          ->references( 'id' )
                          ->on( 'mailing_lists' );

                    $table->timestamps();
                }
            );


            Schema::connection( self::DB_CONNECTOR )
                  ->create( self::DB_TABLE_NAME_ACCOUNT_VERRIFIED_AT, 
                function ( Blueprint $table ) 
                {
                    $table->engine = self::DB_ENGINE_DEFAULT;

                    $table->id();
                    $table->string( 'content_token' );


                    $table->bigInteger( 'account_id' )
                          ->unsigned()
                          ->unique();
                  
                    $table->foreign( 'account_id' )
                          ->references( 'id' )
                          ->on( AccountModel::DB_TABLE_NAME );

                }
            );

            Schema::connection( self::DB_CONNECTOR )
                  ->create( 'status', 
                function ( Blueprint $table ) 
                {
                    $table->engine = self::DB_ENGINE_DEFAULT;

                    $table->id();
                    $table->string('content')->index();

                }
            );


            Schema::connection( self::DB_CONNECTOR )
                  ->create( 'ip_address_type', 
                function ( Blueprint $table ) 
                {
                    $table->engine = self::DB_ENGINE_DEFAULT;

                    $table->id();
                    $table->string('content')->index()->unique();

                }
            );


            Schema::connection( self::DB_CONNECTOR )
                  ->create( 'label_ip_address', 
                function ( Blueprint $table ) 
                {
                    $table->engine = self::DB_ENGINE_DEFAULT;

                    $table->id();
                    $table->ipAddress('content')->index()->unique();

                }
            );


            Schema::connection( self::DB_CONNECTOR )
                  ->create( self::DB_TABLE_NAME_ACCOUNT_ACTIVITY_VISITS, 
                function ( Blueprint $table ) 
                {
                    $table->engine = self::DB_ENGINE_DEFAULT;

                    $table->id();

                    $table->bigInteger( 'account_id' )
                          ->unsigned();

                    $table->bigInteger( 'status_id' )
                          ->unsigned();
                    
                    $table->bigInteger( 'address_id' )
                          ->unsigned();

                    $table->bigInteger( 'address_type_id' )
                          ->unsigned();

                    $table->json( 'request' );
                    
                    $table->timestamp( 'authenticated_at' )
                          ->nullable()
                          ->useCurrent();

                    $table->foreign( 'account_id' )
                          ->references( 'id' )
                          ->on( AccountModel::DB_TABLE_NAME );

                    $table->foreign( 'status_id' )
                          ->references( 'id' )
                          ->on( 'status' );

                    $table->foreign( 'address_type_id' )
                          ->references( 'id' )
                          ->on( 'ip_address_type' );

                    $table->foreign( 'address_id' )
                          ->references( 'id' )
                          ->on( 'label_ip_address' );
                }
            );

            
            Schema::connection( self::DB_CONNECTOR )
                  ->create( self::DB_TABLE_NAME_FAILED_JOBS, 
                function ( Blueprint $table ) 
                {
                    $table->engine = self::DB_ENGINE_DEFAULT;

                    $table->id();

                    $table->string( 'uuid' )
                          ->unique();

                    $table->text( 'connection' );
                    $table->text( 'queue' );
                    
                    $table->longText( 'payload' );
                    $table->longText( 'exception' );
                    
                    $table->timestamp( 'failed_at' )
                          ->useCurrent();
                }
            );


            Schema::connection( self::DB_CONNECTOR )
                  ->create( self::DB_TABLE_NAME_PASSWORD_RESET, 
                function ( Blueprint $table ) 
                {
                    $table->engine = self::DB_ENGINE_DEFAULT;
                    
                    $table->id();

                    $table->bigInteger( 'email_id' )
                          ->unsigned()
                          ->index();

                    $table->string( 'token' );
                    
                    $table->timestamp( 'created_at' )
                          ->nullable()
                          ->useCurrent();

                    $table->foreign( 'email_id' )
                          ->references( 'id' )
                          ->on( 'mailing_lists' );
                }
            );
        }
        

        
        public function down()
        {
            Schema::connection( self::DB_CONNECTOR )
                  ->dropIfExists( self::DB_TABLE_NAME_ACCOUNT );

            Schema::connection( self::DB_CONNECTOR )
                  ->dropIfExists( self::DB_TABLE_NAME_FAILED_JOBS );

            Schema::connection( self::DB_CONNECTOR )
                  ->dropIfExists( self::DB_TABLE_NAME_PASSWORD_RESET );
        }
    };
?>