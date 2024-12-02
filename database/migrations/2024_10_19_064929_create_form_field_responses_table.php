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
            Schema::create('form_field_responses', function (Blueprint $table) {
                $table->id();
                $table->foreignId('form_response_id')->constrained('form_responses')->onDelete('cascade');  // Relación con las respuestas
                $table->foreignId('form_field_id')->constrained('form_fields')->onDelete('cascade');  // Relación con los campos
                $table->text('value');  // Valor de la respuesta
                $table->timestamps();
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::dropIfExists('form_field_responses');
        }
    };
