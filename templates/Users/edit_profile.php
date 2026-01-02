<?php

/**
 * Edit Profile - Customer Profile Edit Form
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Montserrat:wght@500;600;700;800&display=swap');

    .account-wrapper {
        background-color: #f8fafc;
        min-height: 100vh;
        padding: 40px 0;
    }

    .page-title {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.2em;
        color: #64748b;
        text-align: center;
        margin-bottom: 8px;
    }

    .page-heading {
        font-family: 'Montserrat', sans-serif;
        font-size: 3.5rem;
        font-weight: 900;
        color: #0f172a;
        text-align: center;
        margin-bottom: 32px;
        letter-spacing: -1px;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .page-heading .accent {
        color: #1e40af;
    }

    /* Profile Card */
    .profile-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(0, 0, 0, 0.04);
        padding: 32px;
        margin-bottom: 32px;
    }

    .profile-header {
        display: flex;
        align-items: center;
        gap: 24px;
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: 3px solid #059669;
        object-fit: cover;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #059669;
        overflow: hidden;
        box-shadow: 0 0 0 4px rgba(5, 150, 105, 0.15);
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .profile-info {
        flex: 1;
    }

    .profile-name {
        font-family: 'Montserrat', sans-serif;
        font-size: 1.25rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 4px 0;
    }

    .profile-subtitle {
        font-family: 'Inter', sans-serif;
        font-size: 0.9rem;
        color: #64748b;
        margin: 0;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: transparent;
        border: 2px solid #e2e8f0;
        color: #0f172a;
        padding: 12px 24px;
        border-radius: 50px;
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-back:hover {
        border-color: #0f172a;
        background: #0f172a;
        color: #ffffff;
    }

    /* Form Card */
    .form-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border: 1px solid rgba(0, 0, 0, 0.04);
        overflow: hidden;
        margin-bottom: 24px;
    }

    .form-card-header {
        background: #1e293b;
        padding: 16px 24px;
    }

    .form-card-header h5 {
        font-family: 'Inter', sans-serif;
        font-size: 0.85rem;
        font-weight: 600;
        color: #ffffff;
        margin: 0;
    }

    .form-card-body {
        padding: 24px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-label {
        font-family: 'Inter', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #64748b;
        margin-bottom: 8px;
        display: block;
    }

    .form-control {
        font-family: 'Inter', sans-serif;
        font-size: 0.95rem;
        border-radius: 12px;
        border: 2px solid #e2e8f0;
        padding: 12px 16px;
        width: 100%;
        transition: all 0.2s ease;
        background: #ffffff;
    }

    .form-control:focus {
        border-color: #0f172a;
        box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.1);
        outline: none;
    }

    .form-control::placeholder {
        color: #94a3b8;
    }

    .form-hint {
        font-family: 'Inter', sans-serif;
        font-size: 0.75rem;
        color: #94a3b8;
        margin-top: 6px;
    }

    /* Avatar Preview */
    .avatar-upload-container {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .current-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        border: 2px solid #e2e8f0;
        object-fit: cover;
    }

    .file-input-wrapper {
        flex: 1;
    }

    /* Buttons */
    .btn-save {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: #0f172a;
        color: #ffffff;
        padding: 14px 32px;
        border-radius: 50px;
        font-family: 'Montserrat', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-save:hover {
        background: #1e293b;
        transform: translateY(-2px);
    }

    .btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: transparent;
        border: 2px solid #e2e8f0;
        color: #64748b;
        padding: 12px 24px;
        border-radius: 50px;
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-cancel:hover {
        border-color: #ef4444;
        color: #ef4444;
    }

    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        padding: 24px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
    }

    @media (max-width: 768px) {
        .profile-header {
            flex-direction: column;
            text-align: center;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-save, .btn-cancel {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<div class="account-wrapper">
    <div class="container">

        <!-- Page Title -->
        <p class="page-title">Account Settings</p>
        <h1 class="page-heading">Edit <span class="accent">Profile</span></h1>

        <!-- Profile Card Header -->
        <div class="profile-card">
            <div class="profile-header">
                <?php if (!empty($user->avatar) && file_exists(WWW_ROOT . 'img' . DS . $user->avatar)): ?>
                    <div class="profile-avatar">
                        <img src="<?= $this->Url->webroot('img/' . $user->avatar) ?>" alt="Avatar">
                    </div>
                <?php else: ?>
                    <div class="profile-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                <?php endif; ?>

                <div class="profile-info">
                    <h2 class="profile-name"><?= h($user->name) ?></h2>
                    <p class="profile-subtitle">Update your personal information</p>
                </div>

                <?= $this->Html->link(
                    'Back to Profile',
                    ['action' => 'myAccount'],
                    ['class' => 'btn-back', 'escape' => false]
                ) ?>
            </div>
        </div>

        <!-- Edit Form -->
        <?= $this->Form->create($user, ['type' => 'file']) ?>

        <!-- Personal Information -->
        <div class="form-card">
            <div class="form-card-header">
                <h5>Personal Information</h5>
            </div>
            <div class="form-card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="name">Full Name</label>
                            <?= $this->Form->text('name', [
                                'class' => 'form-control',
                                'id' => 'name',
                                'placeholder' => 'Enter your full name'
                            ]) ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="ic_number">IC Number</label>
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
                            <label class="form-label" for="email">Email Address</label>
                            <?= $this->Form->email('email', [
                                'class' => 'form-control',
                                'id' => 'email',
                                'placeholder' => 'Enter your email'
                            ]) ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="phone">Phone Number</label>
                            <?= $this->Form->text('phone', [
                                'class' => 'form-control',
                                'id' => 'phone',
                                'placeholder' => 'Enter your phone number'
                            ]) ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="address">Address</label>
                    <?= $this->Form->textarea('address', [
                        'class' => 'form-control',
                        'id' => 'address',
                        'placeholder' => 'Enter your address',
                        'rows' => 3
                    ]) ?>
                </div>
            </div>
        </div>

        <!-- Security & Avatar -->
        <div class="form-card">
            <div class="form-card-header">
                <h5>Security & Profile Picture</h5>
            </div>
            <div class="form-card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="password">New Password</label>
                            <?= $this->Form->password('password', [
                                'class' => 'form-control',
                                'id' => 'password',
                                'placeholder' => 'Enter new password',
                                'value' => '',
                                'required' => false
                            ]) ?>
                            <p class="form-hint">Leave blank to keep your current password</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label" for="avatar_file">Profile Picture</label>
                            <div class="avatar-upload-container">
                                <?php if (!empty($user->avatar) && file_exists(WWW_ROOT . 'img' . DS . $user->avatar)): ?>
                                    <img src="<?= $this->Url->webroot('img/' . $user->avatar) ?>" alt="Current Avatar" class="current-avatar">
                                <?php endif; ?>
                                <div class="file-input-wrapper">
                                    <?= $this->Form->file('avatar_file', [
                                        'class' => 'form-control',
                                        'id' => 'avatar_file',
                                        'accept' => 'image/jpeg,image/png,image/gif,image/webp'
                                    ]) ?>
                                    <p class="form-hint">JPG, PNG, GIF, WebP (Max 2MB)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <?= $this->Html->link(
                    'Cancel',
                    ['action' => 'myAccount'],
                    ['class' => 'btn-cancel', 'escape' => false]
                ) ?>
                <button type="submit" class="btn-save">Save Changes</button>
            </div>
        </div>

        <?= $this->Form->end() ?>

    </div>
</div>