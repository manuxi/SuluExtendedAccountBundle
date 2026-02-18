<?php

declare(strict_types=1);

namespace Manuxi\SuluExtendedAccountBundle\Tests\Admin;

use Manuxi\SuluExtendedAccountBundle\Admin\ExtendedAccountAdmin;
use PHPUnit\Framework\TestCase;
use Sulu\Bundle\AdminBundle\Admin\Admin;
use Sulu\Bundle\AdminBundle\Admin\View\FormViewBuilderInterface;
use Sulu\Bundle\AdminBundle\Admin\View\View;
use Sulu\Bundle\AdminBundle\Admin\View\ViewBuilderFactoryInterface;
use Sulu\Bundle\AdminBundle\Admin\View\ViewBuilderInterface;
use Sulu\Bundle\AdminBundle\Admin\View\ViewCollection;
use Sulu\Bundle\ContactBundle\Admin\ContactAdmin;

class ExtendedAccountAdminTest extends TestCase
{
    private ExtendedAccountAdmin $admin;
    private ViewBuilderFactoryInterface $viewBuilderFactory;

    protected function setUp(): void
    {
        $this->viewBuilderFactory = $this->createMock(ViewBuilderFactoryInterface::class);
        $this->admin = new ExtendedAccountAdmin($this->viewBuilderFactory);
    }

    public function testExtendsAdmin(): void
    {
        $this->assertInstanceOf(Admin::class, $this->admin);
    }

    public function testGetPriority(): void
    {
        $this->assertSame(
            ContactAdmin::getPriority() - 1,
            ExtendedAccountAdmin::getPriority()
        );
    }

    public function testConfigureViewsAddsTwoTabs(): void
    {
        $detailsView = $this->createMock(View::class);
        $detailsView->method('getOption')->with('tabOrder')->willReturn(1024);

        $detailsViewBuilder = $this->createMock(ViewBuilderInterface::class);
        $detailsViewBuilder->method('getView')->willReturn($detailsView);

        $viewCollection = $this->createMock(ViewCollection::class);
        $viewCollection->method('has')
            ->with('sulu_contact.account_edit_form.details')
            ->willReturn(true);
        $viewCollection->method('get')
            ->with('sulu_contact.account_edit_form.details')
            ->willReturn($detailsViewBuilder);

        $formViewBuilder = $this->createMock(FormViewBuilderInterface::class);
        $formViewBuilder->method('setResourceKey')->willReturn($formViewBuilder);
        $formViewBuilder->method('setFormKey')->willReturn($formViewBuilder);
        $formViewBuilder->method('setTabTitle')->willReturn($formViewBuilder);
        $formViewBuilder->method('addToolbarActions')->willReturn($formViewBuilder);
        $formViewBuilder->method('setTabOrder')->willReturn($formViewBuilder);
        $formViewBuilder->method('setParent')->willReturn($formViewBuilder);

        $this->viewBuilderFactory->expects($this->exactly(2))
            ->method('createFormViewBuilder')
            ->willReturn($formViewBuilder);

        $viewCollection->expects($this->exactly(2))
            ->method('add');

        $this->admin->configureViews($viewCollection);
    }

    public function testConfigureViewsSkipsWhenDetailsTabMissing(): void
    {
        $viewCollection = $this->createMock(ViewCollection::class);
        $viewCollection->method('has')
            ->with('sulu_contact.account_edit_form.details')
            ->willReturn(false);

        $viewCollection->expects($this->never())->method('add');

        $this->admin->configureViews($viewCollection);
    }
}