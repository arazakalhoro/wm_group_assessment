<?php

namespace acceptance;

use app\models\User;
use yii\helpers\Url;

class ChangePasswordCest
{
    public function _before(\AcceptanceTester $I)
    {
        // Login as a user before each test
        $I->amLoggedInAs(User::findOne(['email' => 'admin@example.com'])); // Replace with your test user credentials
    }

    public function changePasswordTest(\AcceptanceTester $I)
    {
        $I->amOnPage(Url::to(['user/changepassword'])); // Adjust the URL if needed

        // Fill in and submit the change password form
        $I->seeElement('#change-password');
        $I->fillField('input[name="ChangePasswordForm[currentPassword]"]', 'currentPassword123');
        $I->fillField('input[name="ChangePasswordForm[newPassword]"]', 'newPassword123');
        $I->fillField('input[name="ChangePasswordForm[newPasswordRepeat]"]', 'newPassword123');
        $I->click('Change');

        // Assert successful password change message
        $I->see('Password changed successfully.', '.alert-success');

    }
}