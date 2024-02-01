<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('estados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 15);
            $table->timestamps();
        });


        Schema::create('provincias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 50);
            $table->timestamps();
        });

        Schema::create('cantons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('provincia_id');
            $table->string('nombre', 50);
            $table->timestamps();
            $table->foreign('provincia_id')->references('id')->on('provincias');
        });

        Schema::create('parroquias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('provincia_id');
            $table->unsignedBigInteger('canton_id');
            $table->string('nombre', 50);
            $table->timestamps();
            $table->foreign('provincia_id')->references('id')->on('provincias');
            $table->foreign('canton_id')->references('id')->on('cantons');
        });

        Schema::create('sangres', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 10); 
            $table->timestamps();
        });

        Schema::create('grados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 20);
            $table->timestamps();
        });

        Schema::create('rangos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('grado_id');
            $table->string('nombre', 20);
            $table->timestamps();
            $table->foreign('grado_id')->references('id')->on('grados');
        });

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('lastname')->unique();
            $table->string('cedula')->unique();
            $table->date('fecha_nacimiento');
            $table->unsignedBigInteger('sangre_id');
            $table->unsignedBigInteger('provincia_id');
            $table->unsignedBigInteger('canton_id');
            $table->unsignedBigInteger('parroquia_id');
            $table->string('telefono', 10);
            $table->unsignedBigInteger('grado_id');
            $table->unsignedBigInteger('rango_id');
            $table->unsignedBigInteger('estado_id');
            $table->string('usuario')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('sangre_id')->references('id')->on('sangres');
            $table->foreign('provincia_id')->references('id')->on('provincias');
            $table->foreign('canton_id')->references('id')->on('cantons');
            $table->foreign('parroquia_id')->references('id')->on('parroquias');
            $table->foreign('grado_id')->references('id')->on('grados');
            $table->foreign('rango_id')->references('id')->on('rangos');
            $table->foreign('estado_id')->references('id')->on('estados');
        });

            Schema::create('distritos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('provincia_id');
                $table->unsignedBigInteger('canton_id');
                $table->unsignedBigInteger('parroquia_id');
                $table->string('nombre', 20);
                $table->string('codigo', 20);
                $table->unsignedBigInteger('estado_id');
                $table->timestamps();
                $table->foreign('provincia_id')->references('id')->on('provincias');
                $table->foreign('canton_id')->references('id')->on('cantons');
                $table->foreign('parroquia_id')->references('id')->on('parroquias');
                $table->foreign('estado_id')->references('id')->on('estados');
            });

            Schema::create('circuitos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('provincia_id');
                $table->unsignedBigInteger('canton_id');
                $table->unsignedBigInteger('parroquia_id');
                $table->unsignedBigInteger('distrito_id');
                $table->string('nombre', 20);
                $table->string('codigo', 20);
                $table->unsignedBigInteger('estado_id');
                $table->timestamps();
                $table->foreign('provincia_id')->references('id')->on('provincias');
                $table->foreign('canton_id')->references('id')->on('cantons');
                $table->foreign('parroquia_id')->references('id')->on('parroquias');
                $table->foreign('distrito_id')->references('id')->on('distritos');
                $table->foreign('estado_id')->references('id')->on('estados');
            });
    
            Schema::create('subcircuitos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('provincia_id');
                $table->unsignedBigInteger('canton_id');
                $table->unsignedBigInteger('parroquia_id');
                $table->unsignedBigInteger('distrito_id');
                $table->unsignedBigInteger('circuito_id');
                $table->string('nombre', 20);
                $table->string('codigo', 20);
                $table->unsignedBigInteger('estado_id');
                $table->timestamps();
                $table->foreign('provincia_id')->references('id')->on('provincias');
                $table->foreign('canton_id')->references('id')->on('cantons');
                $table->foreign('parroquia_id')->references('id')->on('parroquias');
                $table->foreign('distrito_id')->references('id')->on('distritos');
                $table->foreign('circuito_id')->references('id')->on('circuitos');
                $table->foreign('estado_id')->references('id')->on('estados');
            });
    
            Schema::create('tvehiculos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nombre', 50);
                $table->timestamps();  
            });
    
            Schema::create('marcas', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('tvehiculo_id');
                $table->string('nombre', 50);
                $table->timestamps();
                $table->foreign('tvehiculo_id')->references('id')->on('tvehiculos');
            });
    
            Schema::create('modelos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('marca_id');
                $table->string('nombre', 50);
                $table->timestamps();
                $table->foreign('marca_id')->references('id')->on('marcas');
            });

            Schema::create('vcargas', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nombre', 10);
                $table->timestamps();
                
            });

            Schema::create('vpasajeros', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nombre', 10); 
                $table->timestamps();
            });
    
            Schema::create('vehiculos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('tvehiculo_id');
                $table->string('placa', 8)->unique(); 
                $table->string('chasis', 20)->unique();
                $table->unsignedBigInteger('marca_id');
                $table->unsignedBigInteger('modelo_id');
                $table->string('motor', 20)->unique(); 
                $table->integer('kilometraje');
                $table->decimal('cilindraje', 3, 2);
                $table->unsignedBigInteger('vcarga_id'); 
                $table->unsignedBigInteger('vpasajero_id'); 
                $table->unsignedBigInteger('estado_id');
                $table->timestamps();
                $table->foreign('tvehiculo_id')->references('id')->on('tvehiculos');
                $table->foreign('marca_id')->references('id')->on('marcas');
                $table->foreign('modelo_id')->references('id')->on('modelos');
                $table->foreign('vcarga_id')->references('id')->on('vcargas');
                $table->foreign('vpasajero_id')->references('id')->on('vpasajeros');
                $table->foreign('estado_id')->references('id')->on('estados');
            });
    
            Schema::create('asignacions', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nombre', 50);
                $table->timestamps();
            });

            Schema::create('usersubcircuitos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('provincia_id');
                $table->unsignedBigInteger('canton_id');
                $table->unsignedBigInteger('parroquia_id');
                $table->unsignedBigInteger('distrito_id');
                $table->unsignedBigInteger('circuito_id');
                $table->unsignedBigInteger('subcircuito_id');
                $table->unsignedBigInteger('asignacion_id');
                $table->timestamps();
                $table->foreign('user_id')->references('id')->on('users');
                $table->foreign('provincia_id')->references('id')->on('provincias');
                $table->foreign('canton_id')->references('id')->on('cantons');
                $table->foreign('parroquia_id')->references('id')->on('parroquias');
                $table->foreign('distrito_id')->references('id')->on('distritos');
                $table->foreign('circuito_id')->references('id')->on('circuitos');
                $table->foreign('subcircuito_id')->references('id')->on('subcircuitos');
                $table->foreign('asignacion_id')->references('id')->on('asignacions');
            });
    
            Schema::create('vehisubcircuitos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('vehiculo_id');
                $table->unsignedBigInteger('provincia_id');
                $table->unsignedBigInteger('canton_id');
                $table->unsignedBigInteger('parroquia_id');
                $table->unsignedBigInteger('distrito_id');
                $table->unsignedBigInteger('circuito_id');
                $table->unsignedBigInteger('subcircuito_id');
                $table->unsignedBigInteger('asignacion_id');
                $table->timestamps();
                $table->foreign('vehiculo_id')->references('id')->on('vehiculos');
                $table->foreign('provincia_id')->references('id')->on('provincias');
                $table->foreign('canton_id')->references('id')->on('cantons');
                $table->foreign('parroquia_id')->references('id')->on('parroquias');
                $table->foreign('distrito_id')->references('id')->on('distritos');
                $table->foreign('circuito_id')->references('id')->on('circuitos');
                $table->foreign('subcircuito_id')->references('id')->on('subcircuitos');
                $table->foreign('asignacion_id')->references('id')->on('asignacions');
            });

            Schema::create('asignarvehiculos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('vehisubcircuito_id');
                $table->unsignedBigInteger('user_id');
                $table->timestamps();
                $table->foreign('vehisubcircuito_id')->references('id')->on('vehisubcircuitos');
                $table->foreign('user_id')->references('id')->on('users');
            });
    
            //Tipo mantenimiento
            Schema::create('mantetipos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nombre', 50);
                $table->decimal('valor', 5, 2);
                $table->text('descripcion');
                $table->timestamps();
            });
            //Estado mantenimiento
            Schema::create('mantestados', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nombre', 11);
                $table->timestamps();
            });

            Schema::create('mantenimientos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('vehiculo_id');
                $table->integer('orden')->unsigned();
                $table->date('fecha');
                $table->time('hora');
                $table->integer('kilometraje');
                $table->text('observaciones')->nullable();
                $table->unsignedBigInteger('mantestado_id');
                $table->timestamps();
                $table->foreign('user_id')->references('id')->on('users');
                $table->foreign('vehiculo_id')->references('id')->on('vehiculos');
                $table->foreign('mantestado_id')->references('id')->on('mantestados');
            });


            //Registrar Mantenimiento en taller
            Schema::create('vehirecepciones', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('mantenimientos_id');
                $table->date('fecha_ingreso');
                $table->time('hora_ingreso');
                $table->integer('kilometraje');
                $table->text('asunto');
                $table->text('detalle'); 
                $table->unsignedBigInteger('mantetipos_id');
                $table->string('imagen'); 
                $table->timestamps();
                $table->foreign('mantenimientos_id')->references('id')->on('mantenimientos');
                $table->foreign('mantetipos_id')->references('id')->on('mantetipos');
                
            });
            //Entregar vehiculo posterior al mantenimiento
            Schema::create('vehientregas', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('vehirecepciones_id');
                $table->date('fecha_entrega');
                $table->string('p_retiro'); 
                $table->integer('km_actual');
                $table->integer('km_proximo');
                $table->text('observaciones');
                $table->timestamps();
                $table->foreign('vehirecepciones_id')->references('id')->on('vehirecepciones');
            });

            Schema::create('tnovedades', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nombre', 11);
                $table->timestamps();
            });

            Schema::create('novedades', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('user_id');
                $table->text('mensaje');
                $table->unsignedBigInteger('tnovedad_id');
                $table->timestamps();
                $table->foreign('user_id')->references('id')->on('users');
                $table->foreign('tnovedad_id')->references('id')->on('tnovedades');
            });

            //Examen
            Schema::create('treclamos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('nombre');
                $table->timestamps();
            });
            //Examen
            Schema::create('reclamos', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('circuito_id');
                $table->unsignedBigInteger('subcircuito_id');
                $table->unsignedBigInteger('treclamo_id');
                $table->text('detalle');
                $table->string('contacto');
                $table->string('apellidos');
                $table->string('nombres');
                $table->timestamps();

                $table->foreign('circuito_id')->references('id')->on('circuitos');
                $table->foreign('subcircuito_id')->references('id')->on('subcircuitos');
                $table->foreign('treclamo_id')->references('id')->on('treclamos');
            });

            


            
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estados');
        Schema::dropIfExists('provincias');
        Schema::dropIfExists('cantons');
        Schema::dropIfExists('parroquias');
        Schema::dropIfExists('sangres');
        Schema::dropIfExists('grados');
        Schema::dropIfExists('rangos');
        Schema::dropIfExists('users');
        Schema::dropIfExists('distritos');
        Schema::dropIfExists('circuitos');
        Schema::dropIfExists('subcircuitos');
        Schema::dropIfExists('dependencias');
        Schema::dropIfExists('tvehiculos');
        Schema::dropIfExists('marcas');
        Schema::dropIfExists('modelos');
        Schema::dropIfExists('vcargas');
        Schema::dropIfExists('vpasajeros');
        Schema::dropIfExists('vehiculos');
        Schema::dropIfExists('asignaciones');
        Schema::dropIfExists('usubcircuitos');
        Schema::dropIfExists('vsubcircuitos');
        Schema::dropIfExists('emantenimientos');
        Schema::dropIfExists('tmantenimientos');
        Schema::dropIfExists('nmantenimientos');
        Schema::dropIfExists('rmantenimientos');
        Schema::dropIfExists('rvehiculos');
        Schema::dropIfExists('evehiculos');
        
        Schema::dropIfExists('treclamos');
        Schema::dropIfExists('reclamos');

    }
};
