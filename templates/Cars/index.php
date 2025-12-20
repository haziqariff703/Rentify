<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Car> $cars
 */
?>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0"><?= __('Available Cars for Rent') ?></h2>
            <p class="text-muted"><?= __('Choose from our wide range of premium vehicles') ?></p>
        </div>
        <?php 
            $identity = $this->request->getAttribute('authentication')->getIdentity();
            if ($identity && $identity->role === 'admin'): 
        ?>
            <?= $this->Html->link(__('<i class="fas fa-plus me-1"></i> New Car'), ['action' => 'add'], ['class' => 'btn btn-primary', 'escape' => false]) ?>
        <?php endif; ?>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($cars as $car): ?>
        <div class="col">
            <div class="card h-100 border-0 shadow-sm hover-shadow transition-all">
                <div class="position-relative">
                    <?php if ($car->image): ?>
                        <img src="<?= $this->Url->webroot('img/' . $car->image) ?>" class="card-img-top" alt="<?= h($car->car_model) ?>" style="height: 200px; object-fit: cover;">
                    <?php else: ?>
                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-car fa-4x opacity-25"></i>
                        </div>
                    <?php endif; ?>
                    <div class="position-absolute top-0 end-0 m-3">
                        <span class="badge <?= $car->status === 'available' ? 'bg-success' : 'bg-danger' ?> px-3 py-2">
                            <?= h(ucfirst($car->status)) ?>
                        </span>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <span class="text-primary fw-bold small text-uppercase"><?= $car->hasValue('category') ? h($car->category->name) : 'General' ?></span>
                            <h5 class="card-title fw-bold mb-0"><?= h($car->brand) ?> <?= h($car->car_model) ?></h5>
                        </div>
                        <div class="text-end">
                            <span class="h5 fw-bold text-primary mb-0">RM<?= $this->Number->format($car->price_per_day) ?></span>
                            <small class="text-muted d-block"><?= __('per day') ?></small>
                        </div>
                    </div>

                    <div class="row g-2 my-3">
                        <div class="col-6">
                            <div class="d-flex align-items-center text-muted small">
                                <i class="fas fa-cog me-2"></i>
                                <?= h($car->transmission) ?>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center text-muted small">
                                <i class="fas fa-users me-2"></i>
                                <?= $this->Number->format($car->seats) ?> <?= __('Seats') ?>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center text-muted small">
                                <i class="fas fa-calendar me-2"></i>
                                <?= $this->Number->format($car->year) ?>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center text-muted small">
                                <i class="fas fa-tag me-2"></i>
                                <?= h($car->plate_number) ?>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <?= $this->Html->link(__('View Details'), ['action' => 'view', $car->id], ['class' => 'btn btn-outline-primary']) ?>
                        <?php if ($car->status === 'available'): ?>
                            <?= $this->Html->link(__('Book Now'), ['controller' => 'Bookings', 'action' => 'add', '?' => ['car_id' => $car->id]], ['class' => 'btn btn-primary']) ?>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($identity && $identity->role === 'admin'): ?>
                <div class="card-footer bg-transparent border-top-0 p-4 pt-0">
                    <div class="d-flex justify-content-between">
                        <?= $this->Html->link(__('<i class="fas fa-edit me-1"></i> Edit'), ['action' => 'edit', $car->id], ['class' => 'btn btn-sm btn-light text-muted', 'escape' => false]) ?>
                        <?= $this->Form->postLink(
                            __('<i class="fas fa-trash me-1"></i> Delete'),
                            ['action' => 'delete', $car->id],
                            [
                                'confirm' => __('Are you sure you want to delete # {0}?', $car->id),
                                'class' => 'btn btn-sm btn-light text-danger',
                                'escape' => false
                            ]
                        ) ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="paginator mt-5">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?= $this->Paginator->first('<< ' . __('first'), ['class' => 'page-item']) ?>
                <?= $this->Paginator->prev('< ' . __('previous'), ['class' => 'page-item']) ?>
                <?= $this->Paginator->numbers(['class' => 'page-item']) ?>
                <?= $this->Paginator->next(__('next') . ' >', ['class' => 'page-item']) ?>
                <?= $this->Paginator->last(__('last') . ' >>', ['class' => 'page-item']) ?>
            </ul>
        </nav>
        <p class="text-center text-muted small mt-2"><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>

<style>
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.1)!important;
    }
    .transition-all {
        transition: all 0.3s ease-in-out;
    }
    .page-item a {
        color: #0d6efd;
        text-decoration: none;
        padding: 0.5rem 0.75rem;
        border: 1px solid #dee2e6;
    }
    .page-item.active a {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: white;
    }
    .page-item.disabled a {
        color: #6c757d;
        pointer-events: none;
        background-color: #fff;
        border-color: #dee2e6;
    }
</style>
