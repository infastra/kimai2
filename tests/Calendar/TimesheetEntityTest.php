<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Calendar;

use App\Calendar\TimesheetEntity;
use App\Entity\Activity;
use App\Entity\Customer;
use App\Entity\Project;
use App\Entity\Tag;
use App\Entity\Timesheet;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Calendar\TimesheetEntity
 */
class TimesheetEntityTest extends TestCase
{
    public function testConstruct()
    {
        $activity = new Activity();
        $activity->setName('activity');

        $customer = new Customer();
        $customer->setName('customer');

        $project = new Project();
        $project->setName('project');
        $project->setCustomer($customer);

        $timesheet = new Timesheet();
        $timesheet->setActivity($activity);
        $timesheet->setProject($project);
        $timesheet->addTag((new Tag())->setName('foo'));
        $timesheet->addTag((new Tag())->setName('bar'));

        $sut = new TimesheetEntity($timesheet);

        $this->assertEquals('customer', $sut->getCustomer());
        $this->assertEquals('project', $sut->getProject());
        $this->assertEquals('activity', $sut->getTitle());
        $this->assertEquals('foo, bar', $sut->getTags());

        $sut->setId(13);
        $this->assertEquals(13, $sut->getId());

        $date = new \DateTime('-13 hours');
        $sut->setStart($date);
        $this->assertEquals($date, $sut->getStart());

        $date = new \DateTime('-3 hours');
        $sut->setEnd($date);
        $this->assertEquals($date, $sut->getEnd());

        $sut->setTitle('sdfsdf');
        $this->assertEquals('sdfsdf', $sut->getTitle());

        $sut->setCustomer('aaaaaaaa');
        $this->assertEquals('aaaaaaaa', $sut->getCustomer());

        $sut->setProject('bbbbbbbbbb');
        $this->assertEquals('bbbbbbbbbb', $sut->getProject());

        $sut->setActivity('cccccccc');
        $this->assertEquals('cccccccc', $sut->getActivity());

        $sut->setTags('hello, world');
        $this->assertEquals('hello, world', $sut->getTags());

        $this->assertNull($sut->getBorderColor());
        $sut->setBorderColor('#cccccc');
        $this->assertEquals('#cccccc', $sut->getBorderColor());

        $this->assertNull($sut->getBackgroundColor());
        $sut->setBackgroundColor('#ffffff');
        $this->assertEquals('#ffffff', $sut->getBackgroundColor());

        $sut->setDescription('foo-bar');
        $this->assertEquals('foo-bar', $sut->getDescription());
    }
}
