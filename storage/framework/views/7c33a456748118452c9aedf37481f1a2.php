

<?php $__env->startSection("title", "Preguntas Frecuentes"); ?>

<?php $__env->startSection("content"); ?>
<div class="container py-5">
    <h1 class="mb-5">Preguntas Frecuentes</h1>

    <div class="accordion" id="faqAccordion">
        <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading<?php echo e($index); ?>">
                    <button class="accordion-button <?php if($index != 0): ?> collapsed <?php endif; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo e($index); ?>">
                        <?php echo e($faq["question"]); ?>

                    </button>
                </h2>
                <div id="collapse<?php echo e($index); ?>" class="accordion-collapse collapse <?php if($index == 0): ?> show <?php endif; ?>" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <?php echo e($faq["answer"]); ?>

                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make("layouts.client", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/client/faq.blade.php ENDPATH**/ ?>