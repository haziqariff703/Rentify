<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<style>
    .profile-edit-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 40px;
        color: white;
        margin-bottom: 30px;
    }

    .edit-form-card {
        background: white;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid #f0f0f0;
    }

    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-group label {
        font-size: 0.875rem;
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-group .form-control,
    .form-group .form-select {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        padding: 12px 15px;
        font-size: 1rem;
        transition: all 0.3s ease;
        width: 100%;
    }

    .form-group .form-control:focus,
    .form-group .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
        outline: none;
    }

    .btn-save {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-cancel {
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
    }

    .section-title {
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid #f0f0f0;
    }

    .section-title i {
        color: #667eea;
    }

    .password-hint {
        font-size: 0.8rem;
        color: #6c757d;
        margin-top: 0.25rem;
    }

    .avatar-preview {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 3px solid rgba(255, 255, 255, 0.3);
        object-fit: cover;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
    }

    .avatar-thumbnail {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e2e8f0;
    }

    .avatar-upload-container {
        display: flex;
        flex-direction: column;
    }

    .current-avatar {
        display: flex;
        align-items: center;
        gap: 10px;
    }
</style>

<div class="container py-5">
    <!-- Header -->
    <div class="profile-edit-header shadow-sm">
        <div class="row align-items-center">
            <div class="col-auto">
                <div class="avatar-preview-container">
                    <?php if (!empty($user->avatar) && file_exists(WWW_ROOT . 'img' . DS . $user->avatar)): ?>
                        <img src="<?= $this->Url->webroot('img/' . $user->avatar) ?>" alt="Avatar" class="avatar-preview">
                    <?php else: ?>
                        <div class="avatar-preview">
                            <span class="text-white"><?= strtoupper(substr($user->name, 0, 1)) ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="<?= $this->Url->build(['action' => 'index']) ?>" class="text-white opacity-75 decoration-none">Users</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Edit User</li>
                    </ol>
                </nav>
                <h2 class="fw-bold mb-0"><?= h($user->name) ?></h2>
            </div>
            <div class="col-auto">
                <div class="d-flex gap-2">
                    <?= $this->Html->link(
                        '<i class="fas fa-eye me-2"></i>View',
                        ['action' => 'view', $user->id],
                        ['class' => 'btn btn-light rounded-pill px-4', 'escape' => false]
                    ) ?>
                    <?= $this->Html->link(
                        '<i class="fas fa-arrow-left me-2"></i>Back',
                        ['action' => 'index'],
                        ['class' => 'btn btn-light rounded-pill px-4', 'escape' => false]
                    ) ?>
                    <button type="button" class="btn btn-danger rounded-pill px-4" id="delete-btn">
                        <i class="fas fa-trash me-2"></i>Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="edit-form-card">
        <?= $this->Form->create($user, ['type' => 'file', 'id' => 'edit-user-form']) ?>

        <!-- Basic Information -->
        <h5 class="section-title"><i class="fas fa-id-card me-2"></i>Basic Information</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <?= $this->Form->text('name', [
                        'class' => 'form-control',
                        'id' => 'name',
                        'placeholder' => 'Enter full name'
                    ]) ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="ic_number">IC Number</label>
                    <?= $this->Form->text('ic_number', [
                        'class' => 'form-control',
                        'id' => 'ic_number',
                        'placeholder' => 'Enter IC number'
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <?= $this->Form->email('email', [
                        'class' => 'form-control',
                        'id' => 'email',
                        'placeholder' => 'Enter email address'
                    ]) ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <?= $this->Form->text('phone', [
                        'class' => 'form-control',
                        'id' => 'phone',
                        'placeholder' => 'Enter phone number'
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <?= $this->Form->textarea('address', [
                'class' => 'form-control',
                'id' => 'address',
                'placeholder' => 'Enter full address',
                'rows' => 3
            ]) ?>
        </div>

        <hr class="my-4">

        <!-- Account Management -->
        <h5 class="section-title"><i class="fas fa-user-shield me-2"></i>Account Management</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="role">User Role</label>
                    <?= $this->Form->select('role', ['admin' => 'Admin', 'customer' => 'Customer'], [
                        'class' => 'form-select',
                        'id' => 'role'
                    ]) ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="avatar_file">Profile Picture</label>
                    <div class="avatar-upload-container">
                        <?php if (!empty($user->avatar) && file_exists(WWW_ROOT . 'img' . DS . $user->avatar)): ?>
                            <div class="current-avatar mb-2">
                                <img src="<?= $this->Url->webroot('img/' . $user->avatar) ?>" alt="Current Avatar" class="avatar-thumbnail">
                                <small class="text-muted d-block">Current avatar</small>
                            </div>
                        <?php endif; ?>
                        <?= $this->Form->file('avatar_file', [
                            'class' => 'form-control',
                            'id' => 'avatar_file',
                            'accept' => 'image/jpeg,image/png,image/gif,image/webp'
                        ]) ?>
                        <small class="text-muted">Accepted formats: JPG, PNG, GIF, WebP (Max 2MB)</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="password">Change Password</label>
                    <?= $this->Form->password('password', [
                        'class' => 'form-control',
                        'id' => 'password',
                        'placeholder' => 'Enter new password',
                        'value' => '',
                        'required' => false
                    ]) ?>
                    <small class="password-hint">Leave blank to keep the current password</small>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <!-- User Metadata (ID, Dates) -->
        <div class="bg-light p-3 rounded-3 mb-4 d-flex justify-content-between text-muted small">
            <div>
                <i class="fas fa-hashtag me-1"></i> ID: <strong><?= h($user->id) ?></strong>
            </div>
            <div>
                <i class="fas fa-calendar-plus me-1"></i> Created: <strong><?= $user->created->format('d M Y, H:i') ?></strong>
            </div>
            <div>
                <i class="fas fa-calendar-check me-1"></i> Last Modified: <strong><?= $user->modified->format('d M Y, H:i') ?></strong>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-end gap-3">
            <?= $this->Html->link(
                '<i class="fas fa-times me-2"></i>Cancel',
                ['action' => 'index'],
                ['class' => 'btn btn-outline-secondary btn-cancel', 'escape' => false]
            ) ?>
            <button type="submit" class="btn btn-save shadow-sm">
                Save Changes
            </button>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>

<!-- Hidden Delete Form -->
<?= $this->Form->postLink(
    '',
    ['action' => 'delete', $user->id],
    ['id' => 'delete-form', 'style' => 'display:none;']
) ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Delete confirmation with SweetAlert2
        const deleteBtn = document.getElementById('delete-btn');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Delete User?',
                    text: "Are you sure you want to delete <?= h($user->name) ?>? This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="fas fa-trash me-1"></i> Yes, delete it!',
                    cancelButtonText: '<i class="fas fa-times me-1"></i> Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading state
                        Swal.fire({
                            title: 'Deleting...',
                            text: 'Please wait while we delete this user.',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Submit the delete form
                        document.querySelector('#delete-form a').click();
                    }
                });
            });
        }
    });
</script>