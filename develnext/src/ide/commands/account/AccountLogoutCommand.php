<?php
namespace ide\commands\account;

use ide\forms\MessageBoxForm;
use ide\Ide;
use ide\misc\AbstractCommand;

/**
 * Class AccountLogoutCommand
 * @package ide\commands\account
 */
class AccountLogoutCommand extends AbstractCommand
{
    public function getName()
    {
        return "Выйти из аккаунта";
    }

    public function getCategory()
    {
        return 'account';
    }

    public function withBeforeSeparator()
    {
        return true;
    }

    public function onExecute()
    {
        $email = Ide::accountManager()->getAccountEmail();

        $dialog = new MessageBoxForm("Вы точно хотите выйти из своего аккаунта ($email) ?", ['Да', 'Нет']);

        if ($dialog->showDialog()) {
            if ($dialog->getResult() == 'Да') {
                Ide::accountManager()->setAccessToken(null);
                Ide::service()->account()->logoutAsync(null);

                Ide::get()->getMainForm()->toast('Вы успешно вышли из аккаунта');

                Ide::accountManager()->authorize(true);
            }
        }
    }
}