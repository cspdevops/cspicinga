<?php
/* Icinga Web 2 | (c) 2013-2015 Icinga Development Team | GPLv2+ */

/** @var $this \Icinga\Application\Modules\Module */

$this->providePermission(
    'monitoring/command/*',
    $this->translate('Allow all commands')
);
$this->providePermission(
    'monitoring/command/schedule-check',
    $this->translate('Allow scheduling host and service checks')
);
$this->providePermission(
    'monitoring/command/acknowledge-problem',
    $this->translate('Allow acknowledging host and service problems')
);
$this->providePermission(
    'monitoring/command/remove-acknowledgement',
    $this->translate('Allow removing problem acknowledgements')
);
$this->providePermission(
    'monitoring/command/comment/*',
    $this->translate('Allow adding and deleting host and service comments')
);
$this->providePermission(
    'monitoring/command/comment/add',
    $this->translate('Allow commenting on hosts and services')
);
$this->providePermission(
    'monitoring/command/comment/delete',
    $this->translate('Allow deleting host and service comments')
);
$this->providePermission(
    'monitoring/command/downtime/*',
    $this->translate('Allow scheduling and deleting host and service downtimes')
);
$this->providePermission(
    'monitoring/command/downtime/schedule',
    $this->translate('Allow scheduling host and service downtimes')
);
$this->providePermission(
    'monitoring/command/downtime/delete',
    $this->translate('Allow deleting host and service downtimes')
);
$this->providePermission(
    'monitoring/command/process-check-result',
    $this->translate('Allow processing host and service check results')
);
$this->providePermission(
    'monitoring/command/feature/instance',
    $this->translate('Allow processing commands for toggling features on an instance-wide basis')
);
$this->providePermission(
    'monitoring/command/feature/object',
    $this->translate('Allow processing commands for toggling features on host and service objects')
);
$this->providePermission(
    'monitoring/command/send-custom-notification',
    $this->translate('Allow sending custom notifications for hosts and services')
);

$this->provideRestriction(
    'monitoring/filter/objects',
    $this->translate('Restrict views to the Icinga objects that match the filter')
);

$this->provideConfigTab('backends', array(
    'title' => $this->translate('Configure how to retrieve monitoring information'),
    'label' => $this->translate('Backends'),
    'url' => 'config'
));
$this->provideConfigTab('security', array(
    'title' => $this->translate('Configure how to protect your monitoring environment against prying eyes'),
    'label' => $this->translate('Security'),
    'url' => 'config/security'
));
$this->provideSetupWizard('Icinga\Module\Monitoring\MonitoringWizard');

/*
 * Available Search Urls
 */
$this->provideSearchUrl($this->translate('Hosts'), 'monitoring/list/hosts?sort=host_severity&limit=10', 99);
$this->provideSearchUrl($this->translate('Services'), 'monitoring/list/services?sort=service_severity&limit=10', 98);
$this->provideSearchUrl($this->translate('Hostgroups'), 'monitoring/list/hostgroups?limit=10', 97);
$this->provideSearchUrl($this->translate('Servicegroups'), 'monitoring/list/servicegroups?limit=10', 96);

/*
 * Available navigation items
 */
$this->provideNavigationItem('host-action', $this->translate('Host Action'));
$this->provideNavigationItem('service-action', $this->translate('Service Action'));
// Notes are disabled as we're not sure whether to really make a difference between actions and notes
//$this->provideNavigationItem('host-note', $this->translate('Host Note'));
//$this->provideNavigationItem('service-note', $this->translate('Service Note'));

$section = $this->menuSection(N_('Network Services'), array(
    'renderer' => array(
        'SummaryNavigationItemRenderer',
        'state' => 'critical'
    ),
    'icon'      => 'sitemap',
    'priority'  => 20 ,
    'url'      => 'monitoring/list/hostgroups?_host_host_type=networkservice'
));

$section = $this->menuSection(N_('Infrastructure'), array(
    'renderer' => array(
        'SummaryNavigationItemRenderer',
        'state' => 'critical'
    ),
    'icon'      => 'sitemap',
    'priority'  => 30 ,
));

$section->add(N_('CSP Microservices'), array(
    'url'      => 'monitoring/list/cspgroup?_host_host_type=microservice',
    'priority' => 10
));

$section->add(N_('CSP Baremetal'), array(
    'url'      => 'monitoring/list/bmgroup?_host_host_type=baremetal',
    'priority' => 20
));
/*
 * Overview Section
 */
$section = $this->menuSection(N_('Monitor Details'), array(
    'icon'      => 'sitemap',
    'priority'  => 40
));

$section->add(N_('Hosts'), array(
    'url'      => 'monitoring/list/hosts',
    'priority' => 50
));
$section->add(N_('Services'), array(
    'url'      => 'monitoring/list/services',
    'priority' => 60
));
$section->add(N_('Tactical Overview'), array(
    'url'      => 'monitoring/tactical',
    'priority' => 70
));
/*
 * Problems Section
 */
$section = $this->menuSection(N_('Problems'), array(
    'renderer' => array(
        'SummaryNavigationItemRenderer',
        'state' => 'critical'
    ),
    'icon'      => 'block',
    'priority'  => 40
));
$section->add(N_('Host Problems'), array(
    'renderer'  => array(
        'MonitoringBadgeNavigationItemRenderer',
        'columns' => array(
            'hosts_down_unhandled' => $this->translate('%d unhandled hosts down')
        ),
        'state'    => 'critical',
        'dataView' => 'statussummary'
    ),
    'url'       => 'monitoring/list/hosts?host_problem=1&sort=host_severity',
    'priority'  => 50
));
$section->add(N_('Service Problems'), array(
    'renderer'  => array(
        'MonitoringBadgeNavigationItemRenderer',
        'columns' => array(
            'services_critical_unhandled' => $this->translate('%d unhandled services critical')
        ),
        'state'    => 'critical',
        'dataView' => 'statussummary'
    ),
    'url'       => 'monitoring/list/services?service_problem=1&sort=service_severity&dir=desc',
    'priority'  => 60
));
$section->add(N_('Service Grid'), array(
    'url'       => 'monitoring/list/servicegrid?problems',
    'priority'  => 70
));
$section->add(N_('Current Downtimes'), array(
    'url'       => 'monitoring/list/downtimes?downtime_is_in_effect=1',
    'priority'  => 80
));

/*
 * History Section
 */
$section = $this->menuSection(N_('History'), array(
    'icon'      => 'rewind',
    'priority'  => 90
));
$section->add(N_('Event Grid'), array(
    'priority'  => 10,
    'url'       => 'monitoring/list/eventgrid'
));
$section->add(N_('Event Overview'), array(
    'priority'  => 20,
    'url'       => 'monitoring/list/eventhistory?timestamp>=-7%20days'
));
$section->add(N_('Notifications'), array(
    'priority'  => 30,
    'url'       => 'monitoring/list/notifications',
));
$section->add(N_('Timeline'), array(
    'priority'  => 40,
    'url'       => 'monitoring/timeline'
));

/*
 * Reporting Section
 */
$section = $this->menuSection(N_('Reporting'), array(
    'icon'      => 'barchart',
    'priority'  => 100
));

$section->add(N_('Alert Summary'), array(
   'url'    => 'monitoring/alertsummary/index'
));


/*
 * CSS
 */
$this->provideCssFile('service-grid.less');
$this->provideCssFile('tables.less');
