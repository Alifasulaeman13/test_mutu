<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class FrekuensiPengumpulanData extends Model
{
    use HasFactory;
    protected $table = 'frekuensi_pengumpulan_data';
    protected $fillable = ['nama'];
} 