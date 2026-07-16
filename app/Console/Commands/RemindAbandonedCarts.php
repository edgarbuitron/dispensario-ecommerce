<?php

namespace App\Console\Commands;

use App\Mail\AbandonedCartMail;
use App\Models\Cart;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class RemindAbandonedCarts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remind-abandoned-carts {--hours=3 : Horas de inactividad antes de recordar}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía un recordatorio por email a los clientes que dejaron productos en el carrito sin comprar';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $hours = (int) $this->option('hours');

        $carts = Cart::whereNotNull('user_id')
            ->whereNull('reminder_sent_at')
            ->where('updated_at', '<=', now()->subHours($hours))
            ->whereHas('items')
            ->with(['user', 'items.product'])
            ->get();

        foreach ($carts as $cart) {
            if (!$cart->user) {
                continue;
            }

            Mail::to($cart->user->email)->send(new AbandonedCartMail($cart));
            $cart->update(['reminder_sent_at' => now()]);

            $this->info("Recordatorio enviado a {$cart->user->email} (carrito #{$cart->id})");
        }

        $this->info("Total de recordatorios enviados: {$carts->count()}");

        return self::SUCCESS;
    }
}
