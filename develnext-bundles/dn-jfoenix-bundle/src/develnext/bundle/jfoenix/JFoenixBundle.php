<?php
namespace develnext\bundle\jfoenix;

use ide\bundle\AbstractBundle;
use ide\bundle\AbstractJarBundle;
use ide\formats\GuiFormFormat;
use ide\Ide;
use ide\library\IdeLibraryBundleResource;
use ide\project\behaviours\GuiFrameworkProjectBehaviour;
use ide\project\Project;
use php\desktop\Runtime;
use php\xml\DomDocument;

class JFoenixBundle extends AbstractJarBundle
{
    public function isAvailable(Project $project)
    {
        return $project->hasBehaviour(GuiFrameworkProjectBehaviour::class);
    }

    public function onAdd(Project $project, AbstractBundle $owner = null)
    {
        parent::onAdd($project, $owner);

        /** @var GuiFormFormat $format */
        $format = Ide::get()->getRegisteredFormat(GuiFormFormat::class);

        if ($format) {
            /*$format->getDumper()->on('appendImports', function ($nodes, DomDocument $document) {
                $import = $document->createProcessingInstruction('import', 'org.controlsfx.control.*');
                $document->insertBefore($import, $document->getDocumentElement());
            }, __CLASS__);*/

            $format->registerInternalList('.dn/bundle/jfoenix/formComponents');
        }
    }

    public function onRemove(Project $project, AbstractBundle $owner = null)
    {
        parent::onRemove($project, $owner);

        /** @var GuiFormFormat $format */
        $format = Ide::get()->getRegisteredFormat(GuiFormFormat::class);

        if ($format) {
            //$format->getDumper()->off('appendImports', __CLASS__);
            $format->unregisterInternalList('.dn/bundle/jfoenix/formComponents');
        }
    }

    public function onRegister(IdeLibraryBundleResource $resource)
    {
        parent::onRegister($resource);

        Runtime::addJar($resource->getPath() . "/jfoenix.jar");
        Runtime::addJar($resource->getPath() . "/jphp-gui-jfoenix-ext.jar");
    }
}