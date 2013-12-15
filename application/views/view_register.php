<center>
<h1><?php echo $title; ?></h1>
<?php echo validation_errors(); ?>
<?php echo form_open('index.php/hexion/checkRegister'); ?>
Email: <br/>
<input type="text" name="email" value="<?php echo set_value('email'); ?>"/><br/>
Password: <br/>
<input type="password" name="password"/><br/>
Retype Password: <br/>
<input type="Password" name="retypePassword"/><br/>

<input type="submit" value="Login" name="submit"/>
</form>
</center>
