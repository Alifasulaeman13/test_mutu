<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class InterpretasiData extends Model
{
    use HasFactory;
    protected $table = 'interpretasi_data';
    protected $fillable = ['nama'];
} 