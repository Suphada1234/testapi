<?php
namespace App\Models;
use CodeIgniter\Model;

class SilplineModel extends Model{
    protected $table = 'tb_silp_line'; //ชื่อตาราง
    protected $primaryKey = 'silp_id';//คีย์หลัก
    protected $allowedFielde = ['silp_id', 
                                'branch_name',  
                                'posbranch_name', 
                                'name_id', 
                                'pass', 
                                'emp_name', 
                                'start_date', 
                                'end_date', 
                                'mail', 
                                'line_id', 
                                'paynum_month', 
                                'paynum',
                                'pay_date', 
                                'link_silp', 
                                'pass_silp',
                                'date_create',
                                'user_create'];//ฟิลด์ทั้งหมด
}
?>