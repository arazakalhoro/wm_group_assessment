<?php

use app\models\User;
use yii\helpers\Url;

class ProfileCest
{
    public function _before(AcceptanceTester $I)
    {
        // Login as a user before each test
        $I->amLoggedInAs(User::findOne(['email' => 'admin@example.com'])); // Replace with your test user credentials
    }

    public function profileUpdateTest(AcceptanceTester $I)
    {
        $I->amOnPage(Url::to(['user/profile'])); // Adjust the URL if needed

        // Fill in and submit the profile form
        $I->seeElement('#profile-form');
        $I->fillField('input[name="ProfileForm[email]"]', 'newemail@example.com');
        $I->fillField('input[name="ProfileForm[name]"]', 'New Name');
        $I->click('Save');

        // Assert successful profile update message
        $I->see('Profile updated successfully.', '.alert-success');

        // Optionally, assert the updated profile details are visible
        $I->seeInField('input[name="ProfileForm[email]"]', 'newemail@example.com');
        $I->seeInField('input[name="ProfileForm[name]"]', 'New Name');
    }
}
