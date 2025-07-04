<?php return array(
    'root' => array(
        'name' => 'dell/escrowtics',
        'pretty_version' => '1.0.0+no-version-set',
        'version' => '1.0.0.0',
        'reference' => NULL,
        'type' => 'project',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => true,
    ),
    'versions' => array(
        'chillerlan/php-qrcode' => array(
            'pretty_version' => 'v5.0.x-dev',
            'version' => '5.0.9999999.9999999-dev',
            'reference' => '0a897ca7235757a6e59e0949157daa5e8f7c680b',
            'type' => 'library',
            'install_path' => __DIR__ . '/../chillerlan/php-qrcode',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'chillerlan/php-settings-container' => array(
            'pretty_version' => '2.1.5',
            'version' => '2.1.5.0',
            'reference' => 'f705310389264c3578fdd9ffb15aa2cd6d91772e',
            'type' => 'library',
            'install_path' => __DIR__ . '/../chillerlan/php-settings-container',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'components/jquery' => array(
            'pretty_version' => 'dev-master',
            'version' => 'dev-master',
            'reference' => '8edc7785239bb8c2ad2b83302b856a1d61de60e7',
            'type' => 'component',
            'install_path' => __DIR__ . '/../components/jquery',
            'aliases' => array(
                0 => '9999999-dev',
            ),
            'dev_requirement' => false,
        ),
        'dell/escrowtics' => array(
            'pretty_version' => '1.0.0+no-version-set',
            'version' => '1.0.0.0',
            'reference' => NULL,
            'type' => 'project',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'itsjavi/bootstrap-colorpicker' => array(
            'pretty_version' => 'dev-master',
            'version' => 'dev-master',
            'reference' => '5b5f50b19eb7db556097fd3bc4c1c9718a6ef668',
            'type' => 'library',
            'install_path' => __DIR__ . '/../itsjavi/bootstrap-colorpicker',
            'aliases' => array(
                0 => '9999999-dev',
            ),
            'dev_requirement' => false,
        ),
        'twbs/bootstrap' => array(
            'pretty_version' => 'dev-main',
            'version' => 'dev-main',
            'reference' => 'd2d4581790da2618d3fe063dafaa6205c73aabdd',
            'type' => 'library',
            'install_path' => __DIR__ . '/../twbs/bootstrap',
            'aliases' => array(
                0 => '9999999-dev',
            ),
            'dev_requirement' => false,
        ),
        'twitter/bootstrap' => array(
            'dev_requirement' => false,
            'replaced' => array(
                0 => '9999999-dev',
                1 => 'dev-main',
            ),
        ),
    ),
);
