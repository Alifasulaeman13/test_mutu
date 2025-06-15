<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class MetodologiAnalisaData extends Model
{
    use HasFactory;
    protected $table = 'metodologi_analisa_data';
    protected $fillable = ['nama'];
} 