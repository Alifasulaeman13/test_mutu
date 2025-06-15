<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class PublikasiData extends Model
{
    use HasFactory;
    protected $table = 'publikasi_data';
    protected $fillable = ['nama'];
} 