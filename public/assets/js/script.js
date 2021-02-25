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
})