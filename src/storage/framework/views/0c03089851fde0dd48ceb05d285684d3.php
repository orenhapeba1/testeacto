<div class="max-w-2xl mx-auto p-6 bg-white rounded-xl shadow">
    <h2 class="text-xl font-bold mb-4">Responder: <?php echo e($form->name); ?></h2>

    <form wire:submit.prevent="save" class="space-y-6">
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $form->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div>
                <label class="block font-semibold mb-1"><?php echo e($question->title); ?></label>

                <!--[if BLOCK]><![endif]--><?php if($question->type === 'text'): ?>
                    <input type="text" wire:model.defer="responses.<?php echo e($question->id); ?>"
                           class="w-full border rounded p-2">
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["responses.{$question->id}"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                <?php elseif($question->type === 'multiple_choice'): ?>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = json_decode($question->options, true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="inline-flex items-center space-x-2 mr-4">
                            <input type="radio"
                                   wire:model.defer="responses.<?php echo e($question->id); ?>"
                                   value="<?php echo e($option); ?>">
                            <span><?php echo e($option); ?></span>
                        </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Enviar Respostas
        </button>
    </form>

    <!--[if BLOCK]><![endif]--><?php if(session()->has('success')): ?>
        <div class="mt-4 text-green-600">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div>
<?php /**PATH /var/www/html/resources/views/livewire/fill-form.blade.php ENDPATH**/ ?>