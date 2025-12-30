<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="fas fa-user-edit me-2 text-primary"></i>Edit User
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <?= $this->Html->link('Users', ['action' => 'index']) ?>
                    </li>
                    <li class="breadcrumb-item active"><?= h($user->name) ?></li>
                </ol>
            </nav>
        </div>
        <div>
            <?= $this->Html->link(
                '<i class="fas fa-arrow-left me-1"></i> Back to List',
                ['action' => 'index'],
                ['class' => 'btn btn-outline-secondary', 'escape' => false]
            ) ?>
        </div>
    </div>

    <div class="row">
        <!-- Main Form -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-info-circle me-2 text-muted"></i>User Information
                    </h5>
                </div>
                <div class="card-body p-4">
                    <?= $this->Form->create($user, ['id' => 'edit-user-form']) ?>

                    <div class="row g-3">
                        <!-- Name -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-user me-1 text-muted"></i> Full Name
                            </label>
                            <?= $this->Form->control('name', [
                                'label' => false,
                                'class' => 'form-control',
                                'placeholder' => 'Enter full name'
                            ]) ?>
                        </div>

                        <!-- IC Number -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-id-card me-1 text-muted"></i> IC Number
                            </label>
                            <?= $this->Form->control('ic_number', [
                                'label' => false,
                                'class' => 'form-control',
                                'placeholder' => 'Enter IC number'
                            ]) ?>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-envelope me-1 text-muted"></i> Email Address
                            </label>
                            <?= $this->Form->control('email', [
                                'label' => false,
                                'class' => 'form-control',
                                'placeholder' => 'Enter email address'
                            ]) ?>
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-phone me-1 text-muted"></i> Phone Number
                            </label>
                            <?= $this->Form->control('phone', [
                                'label' => false,
                                'class' => 'form-control',
                                'placeholder' => 'Enter phone number'
                            ]) ?>
                        </div>

                        <!-- Address -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-map-marker-alt me-1 text-muted"></i> Address
                            </label>
                            <?= $this->Form->control('address', [
                                'label' => false,
                                'type' => 'textarea',
                                'class' => 'form-control',
                                'rows' => 3,
                                'placeholder' => 'Enter full address'
                            ]) ?>
                        </div>

                        <!-- Password -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-lock me-1 text-muted"></i> Password
                            </label>
                            <?= $this->Form->control('password', [
                                'label' => false,
                                'class' => 'form-control',
                                'placeholder' => 'Leave blank to keep current'
                            ]) ?>
                            <small class="text-muted">Leave blank to keep current password</small>
                        </div>

                        <!-- Role -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-user-tag me-1 text-muted"></i> Role
                            </label>
                            <?= $this->Form->control('role', [
                                'label' => false,
                                'class' => 'form-select',
                                'options' => ['admin' => 'Admin', 'customer' => 'Customer']
                            ]) ?>
                        </div>

                        <!-- Avatar -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                <i class="fas fa-image me-1 text-muted"></i> Avatar URL
                            </label>
                            <?= $this->Form->control('avatar', [
                                'label' => false,
                                'class' => 'form-control',
                                'placeholder' => 'Enter avatar URL or path'
                            ]) ?>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex gap-2 mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-primary px-4" id="submit-btn">
                            <i class="fas fa-save me-1"></i> Save Changes
                        </button>
                        <?= $this->Html->link(
                            '<i class="fas fa-times me-1"></i> Cancel',
                            ['action' => 'index'],
                            ['class' => 'btn btn-outline-secondary', 'escape' => false]
                        ) ?>
                    </div>

                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-semibold">
                        <i class="fas fa-cog me-2 text-muted"></i>Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <?= $this->Html->link(
                            '<i class="fas fa-eye me-1"></i> View User',
                            ['action' => 'view', $user->id],
                            ['class' => 'btn btn-outline-primary', 'escape' => false]
                        ) ?>
                        <button type="button" class="btn btn-outline-danger" id="delete-btn">
                            <i class="fas fa-trash me-1"></i> Delete User
                        </button>
                    </div>
                </div>
            </div>

            <!-- User Info Card -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-semibold">
                        <i class="fas fa-info me-2 text-muted"></i>User Details
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <?php if ($user->avatar): ?>
                            <img src="<?= h($user->avatar) ?>" alt="Avatar" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                        <?php else: ?>
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center mx-auto" style="width: 80px; height: 80px;">
                                <span class="text-white fs-3"><?= strtoupper(substr($user->name, 0, 1)) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <ul class="list-unstyled text-muted small">
                        <li class="mb-2">
                            <i class="fas fa-hashtag me-2"></i>
                            <strong>ID:</strong> <?= h($user->id) ?>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-calendar me-2"></i>
                            <strong>Created:</strong> <?= $user->created->format('d M Y') ?>
                        </li>
                        <li>
                            <i class="fas fa-clock me-2"></i>
                            <strong>Modified:</strong> <?= $user->modified->format('d M Y') ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Delete Form -->
<?= $this->Form->postLink(
    '',
    ['action' => 'delete', $user->id],
    ['id' => 'delete-form', 'style' => 'display:none;']
) ?>