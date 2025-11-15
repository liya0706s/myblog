$(document).ready(function() {
    var $categoryModal = $('#categoryModal');
    var $addBtn = $('#add-category-btn');
    var $saveBtn = $('#save-category-btn');
    var $categoryInput = $('#new-category-name');
    var $categoryError = $('#category-error');
    var $categorySelect = $('#category_id');

    $addBtn.on('click', function() {
        $categoryInput.val('');
        $categoryError.text('');
        $categoryModal.modal('show');
    });

    $saveBtn.on('click', function() {
        var newCategory = $categoryInput.val().trim();

        if (!newCategory) {
            $categoryError.text('請輸入分類名稱！');
            return;
        }

        var exists = false;
        $categorySelect.find('option').each(function() {
            if ($(this).text().trim() === newCategory) {
                exists = true;
                return false;
            }
        });

        if (exists) {
            $categoryError.text('此分類已存在！');
            return;
        }

        var token = $('meta[name="csrf-token"]').attr('content');
        var storeUrl = $('meta[name="category-store-url"]').attr('content');

        $.ajax({
            url: storeUrl,
            type: 'POST',
            data: { name: newCategory, _token: token },
            success: function(response) {
                var $newOption = $('<option>')
                .val(response.category.id)
                .text(response.category.name);
                $categorySelect.append($newOption);
                $categorySelect.val(response.category.id);

                $categoryModal.modal('hide');
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    var err = xhr.responseJSON.errors.name[0];
                    $categoryError.text(err);
                } else {
                    $categoryError.text('新增分類發生錯誤！');
                }
            }
        });
    });

    $categoryModal.on('hidden.bs.modal', function() {
        $addBtn.focus();
    });
});