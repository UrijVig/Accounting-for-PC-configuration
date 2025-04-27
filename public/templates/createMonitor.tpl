<div class="create">
    <h2>Добавление монтора</h2>

    <h4>Введите данные монитора:</h4>

    <form class="form" method="post">

        <div class="form-group">
            <label for="serial_number">Серийный номер*</label>
            <input type="text" name="serial_number" id="serial_number" maxlength="25" required 
                placeholder="serial_number maximum 25 characters"
                value="<?= htmlspecialchars($data['serial_number'] ?? '')?>">
        </div>

        <div class="form-group">
            <label for="model">Модель монитора*</label>
            <input type="text" name="model" id="model" maxlength="25" required 
                placeholder="model maximum 25 characters"
                value="<?= htmlspecialchars($data['model'] ?? '')?>">
        </div>

        <div class="form-group">
            <label for="diagonal">Диагональ (дюймы)*</label>
            <input type="number" name="diagonal" id="diagonal" min="24" step="0.1" required 
                placeholder="diagonal"
                value="<?= htmlspecialchars($data['diagonal'] ?? '')?>">
        </div>

        <div class="form-group">
            <label for="computer_name">Имя подключённого ПК*</label>
            <input type="text" name="computer_name" id="computer_name" maxlength="12" required 
            p   laceholder="computer_name maximum 12 characters"
                value="<?= htmlspecialchars($data['computer_name'] ?? '')?>">
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert error">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>      

        <button type="submit" class="btn primary">Сохранить монитор</button>
    </form>
</div>
