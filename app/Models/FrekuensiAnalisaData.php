<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class FrekuensiAnalisaData extends Model
{
    use HasFactory;
    protected $table = 'frekuensi_analisa_data';
    protected $fillable = ['nama'];
} 