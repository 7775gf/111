<?php
include '../includes/db.php';
include 'templates/header.php';

// Получение списка рецептов для календаря
$stmt = $pdo->query('SELECT planning.*, recipes.title AS recipe_title FROM planning LEFT JOIN recipes ON planning.recipe_id = recipes.id ORDER BY date ASC');
$planned_recipes = $stmt->fetchAll();

// Обработка добавления рецепта в календарь
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_plan'])) {
    $recipe_id = $_POST['recipe_id'];
    $date = $_POST['date'];

    $stmt = $pdo->prepare('INSERT INTO planning (user_id, recipe_id, date) VALUES (1, ?, ?)');
    $stmt->execute([$recipe_id, $date]);

    header('Location: planning.php');
    exit();
}

// Обработка удаления рецепта из календаря
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_from_plan'])) {
    $planning_id = $_POST['planning_id'];

    $stmt = $pdo->prepare('DELETE FROM planning WHERE id = ?');
    $stmt->execute([$planning_id]);

    header('Location: planning.php');
    exit();
}
?>

<h1 class="text-center mb-4">Планирование</h1>

<div class="planning-page">
    <!-- Календарь -->
    <div class="calendar-container">
        <!-- Стрелки для переключения месяцев -->
        <div class="calendar-navigation d-flex justify-content-between align-items-center mb-3">
            <button id="prev-month" class="btn btn-outline-secondary"><i class="fas fa-chevron-left"></i></button>
            <h2 id="current-month-year" class="text-center mb-0"></h2>
            <button id="next-month" class="btn btn-outline-secondary"><i class="fas fa-chevron-right"></i></button>
        </div>

        <!-- Календарь -->
        <div id="calendar" class="calendar"></div>
    </div>

    <!-- Кнопка "Добавить рецепт" -->
    <div class="text-center mt-4">
        <a href="recipe.php" class="btn btn-primary btn-lg">+ Добавить рецепт</a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendar = document.getElementById('calendar');
    const prevMonthBtn = document.getElementById('prev-month');
    const nextMonthBtn = document.getElementById('next-month');
    const currentMonthYear = document.getElementById('current-month-year');

    let currentDate = new Date();

    // Функция для генерации календаря
    function generateCalendar(date) {
        calendar.innerHTML = '';
        const year = date.getFullYear();
        const month = date.getMonth();

        // Заголовок месяца
        currentMonthYear.textContent = new Date(year, month).toLocaleString('ru', { month: 'long', year: 'numeric' });

        // Генерация дней недели
        const daysOfWeek = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'];
        const daysOfWeekRow = document.createElement('div');
        daysOfWeekRow.classList.add('days-of-week', 'd-flex', 'justify-content-between', 'mb-2');
        daysOfWeek.forEach(day => {
            const dayElement = document.createElement('div');
            dayElement.textContent = day;
            dayElement.classList.add('day-of-week', 'text-center', 'flex-fill');
            daysOfWeekRow.appendChild(dayElement);
        });
        calendar.appendChild(daysOfWeekRow);

        // Генерация дней
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        const daysInMonth = lastDay.getDate();
        const startDay = firstDay.getDay() === 0 ? 6 : firstDay.getDay() - 1; // Начинаем с понедельника

        // Создаем пустые ячейки для предыдущего месяца
        for (let i = 0; i < startDay; i++) {
            const emptyDay = document.createElement('div');
            emptyDay.classList.add('day', 'empty', 'text-center', 'flex-fill');
            calendar.appendChild(emptyDay);
        }

        // Создаем ячейки для текущего месяца
        for (let i = 1; i <= daysInMonth; i++) {
            const day = document.createElement('div');
            day.classList.add('day', 'text-center', 'flex-fill');
            if (i === currentDate.getDate() && month === currentDate.getMonth() && year === currentDate.getFullYear()) {
                day.classList.add('today');
            }
            day.textContent = i;

            // Добавляем рецепты в день
            <?php foreach ($planned_recipes as $planned): ?>
                <?php
                $plannedDate = new DateTime($planned['date']);
                if ($plannedDate->format('Y-m') === date('Y-m', strtotime($currentDate))):
                ?>
                    if (i === <?= $plannedDate->format('d') ?>) {
                        const recipeLink = document.createElement('a');
                        recipeLink.href = 'recipe_detail.php?id=<?= $planned['recipe_id'] ?>';
                        recipeLink.textContent = '<?= $planned['recipe_title'] ?>';
                        recipeLink.classList.add('recipe-link', 'd-block', 'mb-1');
                        day.appendChild(recipeLink);

                        const deleteRecipe = document.createElement('form');
                        deleteRecipe.method = 'POST';
                        deleteRecipe.innerHTML = `
                            <input type="hidden" name="planning_id" value="<?= $planned['id'] ?>">
                            <button type="submit" name="remove_from_plan" class="btn btn-sm btn-danger">Удалить</button>
                        `;
                        day.appendChild(deleteRecipe);
                    }
                <?php endif; ?>
            <?php endforeach; ?>

            calendar.appendChild(day);
        }
    }

    // Инициализация календаря
    generateCalendar(currentDate);

    // Переключение месяцев
    prevMonthBtn.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        generateCalendar(currentDate);
    });

    nextMonthBtn.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        generateCalendar(currentDate);
    });
});
</script>

<?php include 'templates/footer.php'; ?>