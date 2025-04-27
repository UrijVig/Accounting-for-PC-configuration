<div class="create">
    <h2>Добавление рабочего места</h2>
    
    <h4>Введите данные системного блока:</h4>
    
    <form class="form" method="post">
        <!-- CSRF защита <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>"> -->
        
        <!-- Поля формы с группировкой -->
        <div class="form-group">
            <label for="serial_number">Серийный номер*</label>
            <input type="text" id="serial_number" name="serial_number" maxlength="8" required placeholder="serial_number maximum 8 characters"
                   value="<?= htmlspecialchars($data['serial_number'] ?? '') ?>">
        </div>
        
        <div class="form-group">
            <label for="computer_name">Имя компьютера*</label>
            <input type="text" id="computer_name" name="computer_name" maxlength="12" required placeholder="computer_name maximum 12 characters"
                   value="<?= htmlspecialchars($data['computer_name'] ?? '') ?>">
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="cpu">Процессор*</label>
                <input type="text" id="cpu" name="cpu" maxlength="50" required placeholder="cpu maximum 50 characters"
                       value="<?= htmlspecialchars($data['cpu'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label for="ram_gb">RAM (GB)*</label>
                <input type="number" id="ram_gb" name="ram_gb" min="1" step="1" required placeholder="ram_gb"
                       value="<?= htmlspecialchars($data['ram_gb'] ?? '') ?>">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="disk_size">Объем диска (GB)*</label>
                <input type="number" id="disk_size" name="disk_size" min="1" step="0.1" required placeholder="disk_size"
                       value="<?= htmlspecialchars($data['disk_size'] ?? '') ?>">
            </div>
            
            <div class="form-group">
                <label for="disk_free">Свободно (GB)*</label>
                <input type="number" id="disk_free" name="disk_free" min="0" step="0.1" required placeholder="disk_free"
                       value="<?= htmlspecialchars($data['disk_free'] ?? '') ?>">
            </div>
        </div>
        
        <div class="form-group">
            <label for="gpu">Видеокарта*</label>
            <input type="text" id="gpu" name="gpu" maxlength="50" required placeholder="gpu maximum 50 characters"
                   value="<?= htmlspecialchars($data['gpu'] ?? '') ?>">
        </div>
        
        <div class="form-group">
            <label for="location">Расположение*</label>
            <input type="text" id="location" name="location" maxlength="10" required placeholder="location maximum 10 characters"
                   value="<?= htmlspecialchars($data['location'] ?? '') ?>">
        </div>
        
        <div class="form-group">
            <label for="description">Описание*</label>
            <textarea id="description" name="description" maxlength="255" placeholder="description maximum 255 characters"><?= 
                htmlspecialchars($data['description'] ?? '') 
            ?></textarea>
        </div>
        
        <?php if (!empty($errors)): ?>
            <div class="alert error">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <button type="submit" class="btn primary">Сохранить конфигурацию ПК</button>
    </form>
</div>