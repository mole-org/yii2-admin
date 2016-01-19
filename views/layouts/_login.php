<script id="login-modal" type="text/template">
  <div class="modal fade login-modal" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="login-panel panel panel-default">
            <div class="panel-heading">
              <strong class="panel-title">用户登录</strong>
            </div>
            <div class="panel-body">
              <form method="post" id="login-form" action="<?= \yii\helpers\Url::toRoute(['/login']) ?>">
                <input style="display:none" type="text" /> <input style="display:none" type="password" />
                <fieldset>
                  <div class="form-group">
                    <input class="form-control" placeholder="用户名" name="username" type="text" autocomplete="off" required="required" autofocus>
                  </div>
                  <div class="form-group">
                    <input class="form-control" placeholder="密　码" name="password" type="password" autocomplete="off" required="required">
                  </div>
                  <!-- Change this to a button or input when using this as a form -->
                  <input type="submit" class="btn btn-lg btn-success btn-block" value="登录" />
                </fieldset>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</script>