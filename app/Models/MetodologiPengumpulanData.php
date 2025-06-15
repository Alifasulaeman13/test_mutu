<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class MetodologiPengumpulanData extends Model
{
    use HasFactory;
    protected $table = 'metodologi_pengumpulan_data';
    protected $fillable = ['nama'];
} 