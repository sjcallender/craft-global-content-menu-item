<?php
namespace fostercommerce\globalcontentmenuitem;

use Craft;
use craft\base\Plugin;
use craft\elements\Entry;
use craft\events\RegisterCpNavItemsEvent;
use craft\web\twig\variables\Cp;
use yii\base\Event;

class GlobalContentMenuItem extends Plugin
{
	// private ?string $globalContentHandle = null;

	public function init()
	{
		parent::init();

		Event::on(
			Cp::class,
			Cp::EVENT_REGISTER_CP_NAV_ITEMS,
			function (RegisterCpNavItemsEvent $event) {
				$this->addMenuItem($event);
			}
		);

		// $this->setGlobalContentHandle();
	}

//	private function setGlobalContentHandle()
//	{
//		$sectionIds = Craft::$app->entries->allSectionIds;
//
//		foreach ($sectionIds as $sectionId) {
//			$section = Craft::$app->entries->getSectionById($sectionId);
//			if ($section && $section->type == 'single' && $section->name == 'Global Content') {
//				$this->globalContentHandle = $section->handle;
//				break;
//			}
//		}
//	}

	private function addMenuItem(RegisterCpNavItemsEvent $event)
	{
//		if ($this->globalContentHandle) {
			$entry = Entry::find()
				->section('globalContent')
				->one();

			if ($entry) {
				$newMenuItem = [
					'label' => 'Global Content',
					'url' => 'entries/globalContent/' . $entry->id,
					'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" aria-hidden="true"><path d="M256 464c7.4 0 27-7.2 47.6-48.4c8.8-17.7 16.4-39.2 22-63.6H186.4c5.6 24.4 13.2 45.9 22 63.6C229 456.8 248.6 464 256 464zM178.5 304h155c1.6-15.3 2.5-31.4 2.5-48s-.9-32.7-2.5-48h-155c-1.6 15.3-2.5 31.4-2.5 48s.9 32.7 2.5 48zm7.9-144H325.6c-5.6-24.4-13.2-45.9-22-63.6C283 55.2 263.4 48 256 48s-27 7.2-47.6 48.4c-8.8 17.7-16.4 39.2-22 63.6zm195.3 48c1.5 15.5 2.2 31.6 2.2 48s-.8 32.5-2.2 48h76.7c3.6-15.4 5.6-31.5 5.6-48s-1.9-32.6-5.6-48H381.8zm58.8-48c-21.4-41.1-56.1-74.1-98.4-93.4c14.1 25.6 25.3 57.5 32.6 93.4h65.9zm-303.3 0c7.3-35.9 18.5-67.7 32.6-93.4c-42.3 19.3-77 52.3-98.4 93.4h65.9zM53.6 208c-3.6 15.4-5.6 31.5-5.6 48s1.9 32.6 5.6 48h76.7c-1.5-15.5-2.2-31.6-2.2-48s.8-32.5 2.2-48H53.6zM342.1 445.4c42.3-19.3 77-52.3 98.4-93.4H374.7c-7.3 35.9-18.5 67.7-32.6 93.4zm-172.2 0c-14.1-25.6-25.3-57.5-32.6-93.4H71.4c21.4 41.1 56.1 74.1 98.4 93.4zM256 512A256 256 0 1 1 256 0a256 256 0 1 1 0 512z"></path></svg>',
				];

				$entriesIndex = null;
				foreach ($event->navItems as $index => $navItem) {
					if ($navItem['label'] === 'Entries') {
						$entriesIndex = $index;
						break;
					}
				}

				if ($entriesIndex !== null) {
					array_splice($event->navItems, $entriesIndex, 0, [$newMenuItem]);
				} else {
					$event->navItems[] = $newMenuItem;
				}
			}
//		}
	}
}
