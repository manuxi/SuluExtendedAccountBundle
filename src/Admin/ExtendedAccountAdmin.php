<?php

declare(strict_types=1);

namespace Manuxi\SuluExtendedAccountBundle\Admin;

use Sulu\Bundle\AdminBundle\Admin\Admin;
use Sulu\Bundle\AdminBundle\Admin\View\ToolbarAction;
use Sulu\Bundle\AdminBundle\Admin\View\ViewBuilderFactoryInterface;
use Sulu\Bundle\AdminBundle\Admin\View\ViewCollection;
use Sulu\Bundle\ContactBundle\Admin\ContactAdmin;

class ExtendedAccountAdmin extends Admin
{
    private ViewBuilderFactoryInterface $viewBuilderFactory;

    public function __construct(
        ViewBuilderFactoryInterface $viewBuilderFactory
    ) {
        $this->viewBuilderFactory = $viewBuilderFactory;
    }

    public function configureViews(ViewCollection $viewCollection): void
    {
        if ($viewCollection->has('sulu_contact.account_edit_form.details')) {
            $accountDetailsFormView = $viewCollection->get('sulu_contact.account_edit_form.details')->getView();

            $viewCollection->add(
                $this->viewBuilderFactory
                    ->createFormViewBuilder('app.extended_account_form', '/extended-account')
                    ->setResourceKey('extended_account')
                    ->setFormKey('extended_account')
                    ->setTabTitle('extended_account.additional_data')
                    ->addToolbarActions([new ToolbarAction('sulu_admin.save')])
                    ->setTabOrder($accountDetailsFormView->getOption('tabOrder') + 1)
                    ->setParent(ContactAdmin::ACCOUNT_EDIT_FORM_VIEW)
            );
        }
    }

    public static function getPriority(): int
    {
        return ContactAdmin::getPriority() - 1;
    }
}
