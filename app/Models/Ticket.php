<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Scopes\TenantScope;

class Ticket extends Model
{
    protected static function booted(): void{
        static::addGlobalScope(new TenantScope);
    }
    
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory;
    protected $primaryKey = 'ticket_id';
    protected $fillable = [
        'tenant_id',
        'user_id',
        'ticket_title',
        'ticket_description',
        'ticket_category',
        'ticket_priority',
        'ticket_status',
        'ticket_created_at',
        'ticket_updated_at',
    ];
    public const categories = ['Billing', 'Query', 'Technical'];
    public const priorities = ['low', 'medium', 'high', 'urgent'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'tenant_id');
    }

    
}
