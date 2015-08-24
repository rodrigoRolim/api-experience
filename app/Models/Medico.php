<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medico extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'MEDICOS';

    /**
     * The database primary key
     *
     * @var string
     */
    protected $primaryKey = array('CRM','TIPO_CR','UF_CONSELHO');

    public function teste(){
//        SELECT
//          c.nome,GET_ATENDIMENTOS_CLIENTE(c.registro, m.id_medico)
//        FROM
//          VW_ATENDIMENTOS A
//          INNER JOIN VW_MEDICOS M ON A.solicitante = m.crm
//          INNER JOIN VW_CLIENTES C ON a.registro = c.registro
//        WHERE A.DATA_ATD >= TO_DATE(:V_DATA_DESDE,'DD/MM/YYYY HH24:MI')
//          AND A.DATA_ATD <= TO_DATE(:V_DATA_ATE,'DD/MM/YYYY HH24:MI')
//          AND M.ID_MEDICO = :V_ID_MEDICO
//        ORDER BY nome
//        GROUP BY nome
    }
}