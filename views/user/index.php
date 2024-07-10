<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JqueryAsset;
/* @var $this yii\web\View */

$this->title = 'User Management';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p class="text-right float-end">
        <?= Html::a('Register New User', ['user/register'], ['class' => 'btn btn-success']) ?>
    </p>

    <table id="user-table" class="table table-striped table-hover">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Created</th>
            <th>Last Login</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

</div>

<?php
JqueryAsset::register($this);
$this->registerJsFile('https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js', ['depends' => [\yii\web\JqueryAsset::class]]);
$this->registerCssFile('https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css');
?>
<style>
    .badge-success {
        background-color: #28a745;
    }
    .badge-danger {
        background-color: #dc3545;
    }
</style>
<script>
    window.onload = function (){
        $('#user-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?= Url::to(['user/ajaxusers']) ?>",
                "type": "GET"
            },
            "columns": [
                { "data": "name" },
                { "data": "email" },
                { "data": "status" },
                { "data": "created_at" },
                { "data": "last_login_at" },
                {
                    "data": "id",
                    "render": function (data, type, row) {
                        return '<a href="<?= Url::to(['user/update']) ?>?id=' + data + '" class="btn btn-primary ' +
                            'btn-xs">Edit</a>' +
                            ' <a href="#" class="btn btn-danger btn-xs delete-user" data-id="' + data + '">Delete</a>';
                    },
                    "orderable": false,
                    "searchable": false
                }
            ],
            "order": [[ 3, "desc" ]] // Default order by 'created' column in descending order
        });

        $('#user-table').on('click', '.delete-user', function(e) {
            e.preventDefault();
            var userId = $(this).data('id');
            var deleteUrl = '<?= Url::to(['user/delete']) ?>?id=' + userId;

            if (confirm('Are you sure you want to delete this user?')) {
                window.location.href = deleteUrl;
            }
        });
    }
</script>
