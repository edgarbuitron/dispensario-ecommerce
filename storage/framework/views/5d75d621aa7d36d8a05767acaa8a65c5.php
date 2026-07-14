

<?php $__env->startSection("title", "Contacto"); ?>

<?php $__env->startSection("content"); ?>
<div class="container py-5">
    <div class="row">
        <div class="col-md-6">
            <h1>Contacto</h1>
            <p>¿Tienes preguntas? Nos encantaría escucharte.</p>

            <form method="POST" action="/contact">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Teléfono</label>
                    <input type="tel" name="phone" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Asunto</label>
                    <input type="text" name="subject" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mensaje</label>
                    <textarea name="message" rows="5" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-dark">Enviar</button>
            </form>
        </div>
        <div class="col-md-6">
            <h2>Información</h2>
            <p><strong>Email:</strong> info@dispensario.com</p>
            <p><strong>Teléfono:</strong> +1 (555) 123-4567</p>
            <p><strong>Dirección:</strong> Calle Principal 123, Ciudad</p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("layouts.client", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/client/contact.blade.php ENDPATH**/ ?>