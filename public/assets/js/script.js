$(function () {
    $(document).on('click', '[data-action=editTask]', function () {
        let task = $(this).parents('td').find('span').addClass('d-none').html();

        $(this).addClass('d-none');
        $(this).parents('td').find('form').removeClass('d-none');
        $(this).parents('td').find('form input').val(task).removeClass('d-none');
    })
    $(document).on('click', '[data-action=editTaskStop]', function () {
        $(this).parents('td').find('span').removeClass('d-none');
        $(this).parents('td').find('button').removeClass('d-none');
        $(this).parents('td').find('form').addClass('d-none');
    })
    $(document).on('click', '[data-action=editTaskStart]', function (event) {
        if ($(this).parents('td').find('span').html() == $(this).parents('td').find('form input').val()) {
            event.preventDefault();
            $('[data-action=editTaskStop]').click();
        }
    })
    $(document).on('click', 'svg', function () {
        let sortOrder, orderBy;
        if( $(this).hasClass('bi-caret-down-fill') ){
            sortOrder = "ASC";
        }
        else {
            sortOrder = "DESC";
        }
        orderBy = $(this).parents('th').attr('name');
        $.post('/setOrder',
            {
                'sortOrder' : sortOrder,
                'orderBy'   : orderBy
            },
            function() {
                window.location.href = '/';
            }
        );
    })
})