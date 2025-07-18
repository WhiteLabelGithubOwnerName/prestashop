<?php
/**
 * WhiteLabelName SDK
 *
 * This library allows to interact with the WhiteLabelName payment service.
 * WhiteLabelName SDK: 1.0.0
 *
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @author customweb GmbH (http://www.customweb.com/)
 * @copyright 2017 - 2025 customweb GmbH
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache Software License (ASL 2.0)
 */

/**
 * Autoload function.
 *
 * After registering this autoload function with SPL, the following line
 * would cause the function to attempt to load the \WhiteLabelMachineName\Sdk\Baz\Qux class
 * from /path/to/project/lib/Baz/Qux.php:
 *
 *      new \WhiteLabelMachineName\Sdk\Baz\Qux;
 *
 * @param string $class the fully-qualified class name.
 */
spl_autoload_register(function ($class) {

    // project-specific namespace prefix
    $prefix = 'WhiteLabelMachineName\\Sdk\\';

    // base directory for the namespace prefix
    $baseDir = dirname(__FILE__) . '/lib/';

    // does the class use the namespace prefix?
    $len = Tools::strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // get the relative class name
    $relativeClass = Tools::substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
}, true, true);
