$(document).ready(function() {
    // Генерация опций для выбора количества гр/мл
    function generateQuantityOptions() {
        var options = [];
        for (var i = 10; i <= 1000; i += 50) {
            options.push('<option value="' + i + '">' + i + ' гр/мл</option>');
        }
        for (var i = 1250; i <= 3000; i += 250) {
            options.push('<option value="' + i + '">' + i + ' гр/мл</option>');
        }
        return options.join('');
    }

    // Добавление ингредиента
    $('#add-ingredient').click(function() {
        var ingredient = $('#ingredient-select').val();
        var ingredientName = $('#ingredient-select option:selected').text();
        var calories = $('#ingredient-select option:selected').data('calories');
        var price = $('#ingredient-select option:selected').data('price');

        if (ingredient && !$('#ingredients-list').find('input[value="' + ingredient + '"]').length) {
            var ingredientHtml = '<div class="input-group mb-2 col-12">' +
                '<input type="hidden" name="ingredients[]" value="' + ingredient + '">' +
                '<input type="text" class="form-control" value="' + ingredientName + '" readonly>' +
                '<select name="quantities[]" class="form-control">' + generateQuantityOptions() + '</select>' + // Добавляем выпадающий список для выбора количества
                '<div class="input-group-append">' +
                '<button class="btn btn-outline-secondary remove-ingredient" type="button">Удалить</button>' +
                '</div>' +
                '</div>';
            $('#ingredients-list').append(ingredientHtml);
        }
    });

    // Удаление ингредиента
    $(document).on('click', '.remove-ingredient', function() {
        $(this).closest('.input-group').remove();
    });

    // Добавление ингредиента в модальное окно "Рецепт из холодильника"
    $('#add-ingredient-find').click(function() {
        var ingredient = $('#ingredient-select-find').val(); // Исправлено на правильный ID
        var ingredientName = $('#ingredient-select-find option:selected').text(); // Исправлено на правильный ID
        var calories = $('#ingredient-select-find option:selected').data('calories'); // Исправлено на правильный ID
        var price = $('#ingredient-select-find option:selected').data('price'); // Исправлено на правильный ID

        if (ingredient && !$('#ingredients-list-find').find('input[value="' + ingredient + '"]').length) {
            var ingredientHtml = '<div class="input-group mb-2">' +
                '<input type="hidden" name="ingredients[]" value="' + ingredient + '">' +
                '<div class="col-4">' + ingredientName + '</div>' +
                '<div class="col-3">' + calories + ' ккал</div>' +
                '<div class="col-3">' + price + ' руб.</div>' +
                '<div class="col-2">' +
                '<button class="btn btn-outline-secondary remove-ingredient-find" type="button">Удалить</button>' +
                '</div>' +
                '</div>';
            $('#ingredients-list-find').append(ingredientHtml); // Исправлено на правильный ID
        }
    });

    // Удаление ингредиента из списка в модальном окне "Рецепт из холодильника"
    $(document).on('click', '.remove-ingredient-find', function() {
        $(this).closest('.input-group').remove();
    });

    // Поиск рецептов по выбранным ингредиентам
    $('#find-recipe-button').click(function() {
        var ingredients = [];
        $('#ingredients-list-find input[name="ingredients[]"]').each(function() {
            ingredients.push($(this).val());
        });

        if (ingredients.length === 0) {
            alert('Пожалуйста, выберите хотя бы один ингредиент.');
            return;
        }

        // Отправка запроса на сервер для поиска рецептов
        findRecipe(ingredients);
    });

    // Функция для поиска рецептов
    function findRecipe(ingredients) {
        $.ajax({
            url: 'find_recipe.php',
            type: 'POST',
            data: { ingredients: ingredients },
            success: function(response) {
                var recipes = JSON.parse(response);
                if (recipes.length > 0) {
                    // Отображение найденных рецептов
                    displayRecipes(recipes);
                } else {
                    // Убираем последний ингредиент и ищем заново
                    ingredients.pop();
                    if (ingredients.length > 0) {
                        findRecipe(ingredients);
                    } else {
                        alert('Рецепт не найден.');
                    }
                }
            },
            error: function(xhr, status, error) {
                alert('Произошла ошибка: ' + error);
            }
        });
    }

    // Функция для отображения найденных рецептов
    function displayRecipes(recipes) {
        var recipesHtml = '<h3>Найденные рецепты:</h3><div class="row">';
        recipes.forEach(function(recipe) {
            recipesHtml += '<div class="col-md-4">' +
                '<div class="card mb-4">' +
                '<img src="' + recipe.image_url + '" class="card-img-top" alt="' + recipe.title + '">' +
                '<div class="card-body">' +
                '<h5 class="card-title">' + recipe.title + '</h5>' +
                '<p class="card-text">' + recipe.description + '</p>' +
                '<a href="recipe.php?id=' + recipe.id + '" class="btn btn-primary">Подробнее</a>' +
                '</div>' +
                '</div>' +
                '</div>';
        });
        recipesHtml += '</div>';
        $('#findRecipeModal .modal-body').html(recipesHtml);
    }

    $('#addRecipeModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Кнопка, которая вызвала модальное окно
        var recipeId = button.data('recipe-id'); // Получаем ID рецепта
        var modal = $(this);
        modal.find('.modal-body #modalCalendar').html(''); // Очищаем календарь

        // Генерация календаря в модальном окне
        var currentDate = new Date();
        generateModalCalendar(currentDate, recipeId);
    });

    function generateModalCalendar(date, recipeId) {
        var calendar = $('#modalCalendar');
        calendar.html('');
        var year = date.getFullYear();
        var month = date.getMonth();

        // Заголовок месяца
        var monthHeader = document.createElement('div');
        monthHeader.textContent = new Date(year, month).toLocaleString('ru', { month: 'long', year: 'numeric' });
        monthHeader.classList.add('text-center', 'mb-3');
        calendar.append(monthHeader);

        // Генерация дней
        var firstDay = new Date(year, month, 1);
        var lastDay = new Date(year, month + 1, 0);
        var daysInMonth = lastDay.getDate();
        var startDay = firstDay.getDay() === 0 ? 6 : firstDay.getDay() - 1; // Начинаем с понедельника

        for (let i = 0; i < startDay; i++) {
            const emptyDay = document.createElement('div');
            emptyDay.classList.add('day', 'empty');
            calendar.append(emptyDay);
        }

        for (let i = 1; i <= daysInMonth; i++) {
            const day = document.createElement('div');
            day.classList.add('day');
            day.textContent = i;
            day.dataset.date = `${year}-${month + 1}-${i}`;
            day.dataset.recipeId = recipeId;
            calendar.append(day);
        }
    }

    $('#modalCalendar').on('click', '.day', function() {
        $('.day').removeClass('selected');
        $(this).addClass('selected');
    });

    $('#confirmDate').click(function() {
        var selectedDay = $('.day.selected');
        if (selectedDay.length > 0) {
            var date = selectedDay.data('date');
            var recipeId = selectedDay.data('recipeId');

            // Отправка данных на сервер
            $.post('planning.php', { add_to_plan: true, recipe_id: recipeId, date: date }, function(response) {
                $('#addRecipeModal').modal('hide');
                alert('Рецепт добавлен в календарь!');
            });
        } else {
            alert('Пожалуйста, выберите дату.');
        }
    });
});