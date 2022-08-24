<?php $__env->startComponent('mail::layout'); ?>

<?php $__env->slot('header'); ?>
<?php $__env->startComponent('mail::header', ['url' => config('app.url')]); ?>
<?php echo e(config('app.name')); ?>

<?php if (isset($__componentOriginala6c60a8eadc3b56c524581de8cda10d4f5a799b4)): ?>
<?php $component = $__componentOriginala6c60a8eadc3b56c524581de8cda10d4f5a799b4; ?>
<?php unset($__componentOriginala6c60a8eadc3b56c524581de8cda10d4f5a799b4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php $__env->endSlot(); ?>


<?php echo e($slot); ?>



<?php if(isset($subcopy)): ?>
<?php $__env->slot('subcopy'); ?>
<?php $__env->startComponent('mail::subcopy'); ?>
<?php echo e($subcopy); ?>

<?php if (isset($__componentOriginalba845ad32dfe5e4470519a452789aeb20250b6fc)): ?>
<?php $component = $__componentOriginalba845ad32dfe5e4470519a452789aeb20250b6fc; ?>
<?php unset($__componentOriginalba845ad32dfe5e4470519a452789aeb20250b6fc); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php $__env->endSlot(); ?>
<?php endif; ?>


<?php $__env->slot('footer'); ?>
<?php $__env->startComponent('mail::footer'); ?>
© <?php echo e(date('Y')); ?> <?php echo e(config('app.name')); ?>. <?php echo app('translator')->get('All rights reserved.'); ?>
<?php if (isset($__componentOriginala991192d5a5d5f731a8cf5f31528af3b372f333c)): ?>
<?php $component = $__componentOriginala991192d5a5d5f731a8cf5f31528af3b372f333c; ?>
<?php unset($__componentOriginala991192d5a5d5f731a8cf5f31528af3b372f333c); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php $__env->endSlot(); ?>
<?php if (isset($__componentOriginalc32b54e0a3261a2d3631146e856277520bd12d21)): ?>
<?php $component = $__componentOriginalc32b54e0a3261a2d3631146e856277520bd12d21; ?>
<?php unset($__componentOriginalc32b54e0a3261a2d3631146e856277520bd12d21); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH /var/www/html/vendor/laravel/framework/src/Illuminate/Mail/resources/views/html/message.blade.php ENDPATH**/ ?>