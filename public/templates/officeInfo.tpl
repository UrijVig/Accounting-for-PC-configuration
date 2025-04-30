<?php if (!empty($locations)): ?>
    <div class="dashboard">
    <?php foreach ($locations as $ldata): ?>
        <div class="location">
            <h3><?= htmlspecialchars($ldata['name'] ?? 'N/A') ?></h3>
            <p class="location-desc"><?= htmlspecialchars($ldata['description'] ?? '') ?></p>
            
            <?php if (!empty($ldata['workplaces'])): ?>
            <div class="workplace-grid">
                <?php foreach ($ldata['workplaces'] as $wdata): ?>
                <div class="workplace-card">
                    <!-- Левая часть - системный блок -->
                    <div class="system-info">
                        <h4><?= htmlspecialchars($wdata['computer_name'] ?? 'N/A') ?></h4>
                        <div class="specs">
                            <p class="info-item">Serial number: <?= htmlspecialchars($wdata['serial_number'] ?? 'N/A') ?></p>
                            <p class="info-item">Brand: <?= htmlspecialchars($wdata['brand'] ?? 'N/A') ?></p>
                            <p class="info-item">CPU: <?= htmlspecialchars($wdata['cpu'] ?? 'N/A') ?></p>
                            <p class="info-item">RAM: <?= htmlspecialchars($wdata['ram_gb'] ?? 'N/A') ?> GB</p>
                            <p class="info-item">Disk size: <?= htmlspecialchars($wdata['disk_size'] ?? 'N/A') ?> GB</p>
                            <p class="info-item">Disk free: <?= htmlspecialchars($wdata['disk_free'] ?? 'N/A') ?> GB</p>
                            <p class="info-item">GPU: <?= htmlspecialchars($wdata['gpu'] ?? 'N/A') ?></p>
                            <p class="info-item">Description: <?= htmlspecialchars($wdata['description'] ?? 'N/A') ?></p>
                        </div>
                    </div>
                    
                    <!-- Правая часть - мониторы (2x2) -->
                    <?php if (!empty($wdata['monitors'])): ?>
                    <div class="monitors-grid">
                        <h2>Подключённые мониторы:</h2>
                        <?php foreach (array_slice($wdata['monitors'], 0, 4) as $mdata): ?>
                        <div class="monitor-item">
                            <p>Brand: <?= htmlspecialchars($mdata['brand'] ?? 'N/A') ?></p>
                            <p>Model: <?= htmlspecialchars($mdata['model'] ?? 'N/A') ?></p>
                            <p>Serial: <?= htmlspecialchars($mdata['serial_number'] ?? 'N/A') ?></p>
                            <p>Diagonal: <?= htmlspecialchars($mdata['diagonal'] ?? 'N/A') ?>"</p>  
                            <p>Description: <?= htmlspecialchars($mdata['description'] ?? 'N/A') ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Нижняя строка - ИБП и периферия -->
                    <div class="bottom-row">
                        <?php if (!empty($wdata['ups'])): ?>
                        <div class="ups-compact">
                            <h2>Источник бесперебойного питания:</h2>
                            <p>Brand: <?= htmlspecialchars($wdata['ups']['brand'] ?? 'N/A') ?></p>
                            <p>Model: <?= htmlspecialchars($wdata['ups']['model'] ?? 'N/A') ?></p>
                            <p>Serial: <?= htmlspecialchars($wdata['ups']['serial_number'] ?? 'N/A') ?></p>
                            <p>power: <?= htmlspecialchars($wdata['ups']['power'] ?? 'N/A') ?></p>  
                            <p>Description: <?= htmlspecialchars($wdata['ups']['description'] ?? 'N/A') ?></p>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($wdata['peripheries'])): ?>
                        <div class="periphery-compact">
                            <h2>Подключённая перифери́я:</h2>
                            <p>keyboard: <?= htmlspecialchars($wdata['peripheries']['keyboard'] ?? 'N/A') ?></p>
                            <p>mouse: <?= htmlspecialchars($wdata['peripheries']['mouse'] ?? 'N/A') ?></p>
                            <p>mousepad: <?= htmlspecialchars($wdata['peripheries']['mousepad'] ?? 'N/A') ?></p>
                            <p>Description: <?= htmlspecialchars($wdata['peripheries']['description'] ?? 'N/A') ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
    </div>
<?php else: ?>
    <p class="no-data">No equipment found</p>
<?php endif; ?>

