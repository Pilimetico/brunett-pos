<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing basic settings with screenshot values
        DB::table('settings')->where('key', 'company_name')->update([
            'value' => 'BRUNETT ECUADOR',
            'description' => 'Nombre Comercial'
        ]);

        DB::table('settings')->where('key', 'company_ruc')->update([
            'value' => '0195159092001',
            'description' => 'RUC de la empresa'
        ]);

        // Insert new extended settings
        DB::table('settings')->insert([
            [
                'key' => 'company_razon_social',
                'value' => 'ATGU S.A.S',
                'group' => 'company',
                'description' => 'Razón Social',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'company_address',
                'value' => 'GRAN COLOMBIA ENTRE OCTAVIO CORDERO Y ABRAHAM SARMIENTO',
                'group' => 'company',
                'description' => 'Dirección',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'company_phone',
                'value' => '0962918108',
                'group' => 'company',
                'description' => 'Teléfono',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'company_customer_service_phone',
                'value' => '',
                'group' => 'company',
                'description' => 'Teléfono Atención al Cliente',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'company_city',
                'value' => 'CUENCA',
                'group' => 'company',
                'description' => 'Ciudad',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'company_country',
                'value' => 'ECUADOR',
                'group' => 'company',
                'description' => 'País',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'company_email',
                'value' => 'info@brunett.shop',
                'group' => 'company',
                'description' => 'Email',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'company_legal_representative',
                'value' => 'Silvester Atarihuana',
                'group' => 'company',
                'description' => 'Representante Legal',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'company_legal_rep_id',
                'value' => '1900623065',
                'group' => 'company',
                'description' => 'Cedula Rep. Legal',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'company_accountant',
                'value' => '',
                'group' => 'company',
                'description' => 'Contador',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'company_accountant_ruc',
                'value' => '',
                'group' => 'company',
                'description' => 'RUC Contador',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'company_special_contributor_num',
                'value' => '',
                'group' => 'company',
                'description' => 'Cont. Esp. #',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'company_special_contributor_since',
                'value' => '',
                'group' => 'company',
                'description' => 'Cont. Esp. Desde',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'company_artisan_qualification',
                'value' => '',
                'group' => 'company',
                'description' => 'Calif. Artesanal',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'company_obligado_contabilidad',
                'value' => 'SI', // Obligado a llevar contabilidad (checkbox) - checked in screenshot
                'group' => 'company',
                'description' => 'Obligado a llevar contabilidad',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'company_rimpe_regime',
                'value' => 'SI', // Contribuyente régimen RIMPE (checkbox) - checked in screenshot
                'group' => 'company',
                'description' => 'Contribuyente régimen RIMPE',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'company_rimpe_type',
                'value' => 'RIMPE para emprendedores', // RIMPE select option in screenshot
                'group' => 'company',
                'description' => 'Tipo de Régimen RIMPE',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'company_retention_agent',
                'value' => 'NO', // Resolución Agente de retención (checkbox) - unchecked in screenshot
                'group' => 'company',
                'description' => 'Agente de retención',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'company_retention_resolution',
                'value' => 'NAC-DNCRASC20-00000001',
                'group' => 'company',
                'description' => 'Resolución Agente de retención',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'company_ticket_legend',
                'value' => "CONDICIONES GENERALES\nEn caso de algún evento con el envío postal que derive en una Petición, Queja, Reclamo, debe comunicarse con servicio al cliente.\nEL OPERADOR POSTAL indemnizará en caso de daño, pérdida, robo, hurto, expoliación o avería, aplicando el REGLAMENTO DE TÍTULOS HABILITANTES Y DE LA GESTIÓN DEL SECTOR POSTAL, siempre y cuando la reclamación cumpla con todas las condiciones estipuladas para un reclamo.\n\nTu privacidad es importante para nosotros. Usamos tus datos para procesar el envío y emitir esta factura. Recuerda que puedes acceder, rectificar o eliminar tu información cuando lo necesites. Consulte cómo hacerlo en nuestra política en www.servientrega.com.ec\n\nEl cliente entiende y conoce de los servicios brindados por el operador postal, por lo cual exime de responsabilidad a este operador de cualquier trámite postal que se moviliza y que no cuente con valor declarado y asegurado.\n\nCliente desea asegurar:\nSI _____    NO  X\n\nAcepto términos y condiciones del servicio",
                'group' => 'company',
                'description' => 'Leyenda del Ticket',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $keys = [
            'company_razon_social',
            'company_address',
            'company_phone',
            'company_customer_service_phone',
            'company_city',
            'company_country',
            'company_email',
            'company_legal_representative',
            'company_legal_rep_id',
            'company_accountant',
            'company_accountant_ruc',
            'company_special_contributor_num',
            'company_special_contributor_since',
            'company_artisan_qualification',
            'company_obligado_contabilidad',
            'company_rimpe_regime',
            'company_rimpe_type',
            'company_retention_agent',
            'company_retention_resolution',
            'company_ticket_legend'
        ];

        DB::table('settings')->whereIn('key', $keys)->delete();

        DB::table('settings')->where('key', 'company_name')->update(['value' => 'Brunett Ecuador', 'description' => 'Nombre de la empresa']);
        DB::table('settings')->where('key', 'company_ruc')->update(['value' => '', 'description' => 'RUC de la empresa']);
    }
};
