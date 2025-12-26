<?php

/**
 * Edit Profile - Customer Profile Edit Form
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

    .form-group .form-control {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        padding: 12px 15px;
        font-size: 1rem;
        transition: all 0.3s ease;
        width: 100%;
    }

    .form-group .form-control:focus {
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
    <div class="profile-edit-header">
        <div class="row align-items-center">
            <div class="col-auto">
                <?php if (!empty($user->avatar) && file_exists(WWW_ROOT . 'img' . DS . $user->avatar)): ?>
                    <img src="<?= $this->Url->webroot('img/' . $user->avatar) ?>" alt="Avatar" class="avatar-preview">
                <?php else: ?>
                    <div class="avatar-preview">
                        <i class="fas fa-user"></i>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col">
                <h2 class="fw-bold mb-1"><i class="fas fa-user-edit me-2"></i>Edit Profile</h2>
                <p class="mb-0 opacity-75">Update your personal information</p>
            </div>
            <div class="col-auto">
                <?= $this->Html->link(
                    '<i class="fas fa-arrow-left me-2"></i>Back to Profile',
                    ['action' => 'myAccount'],
                    ['class' => 'btn btn-light btn-lg rounded-pill px-4', 'escape' => false]
                ) ?>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="edit-form-card">
        <?= $this->Form->create($user, ['type' => 'file']) ?>

        <!-- Personal Information -->
        <h5 class="section-title"><i class="fas fa-id-card me-2"></i>Personal Information</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <?= $this->Form->text('name', [
                        'class' => 'form-control',
                        'id' => 'name',
                        'placeholder' => 'Enter your full name'
                    ]) ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="ic_number">IC Number</label>
                    <?= $this->Form->text('ic_number', [
                        'class' => 'form-control',
                        'id' => 'ic_number',
                        'placeholder' => 'Enter your IC number'
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
                        'placeholder' => 'Enter your email'
                    ]) ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <?= $this->Form->text('phone', [
                        'class' => 'form-control',
                        'id' => 'phone',
                        'placeholder' => 'Enter your phone number'
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <?= $this->Form->textarea('address', [
                'class' => 'form-control',
                'id' => 'address',
                'placeholder' => 'Enter your address',
                'rows' => 3
            ]) ?>
        </div>

        <hr class="my-4">

        <!-- Security -->
        <h5 class="section-title"><i class="fas fa-lock me-2"></i>Security</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="password">New Password</label>
                    <?= $this->Form->password('password', [
                        'class' => 'form-control',
                        'id' => 'password',
                        'placeholder' => 'Enter new password',
                        'value' => '',
                        'required' => false
                    ]) ?>
                    <small class="password-hint">Leave blank to keep your current password</small>
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

        <hr class="my-4">

        <!-- Action Buttons -->
        <div class="d-flex justify-content-end gap-3">
            <?= $this->Html->link(
                '<i class="fas fa-times me-2"></i>Cancel',
                ['action' => 'myAccount'],
                ['class' => 'btn btn-outline-secondary btn-cancel', 'escape' => false]
            ) ?>
            <button type="submit" class="btn btn-save">Save Changes</button>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>