<?php
/**
 * This file is part of the Evolutivo Framework.
 *
 * For the full copyright and license information, view the LICENSE file that was distributed with this source code.
 ********************************************************************************/
require_once 'modules/cbProcessStep/cbProcessStep.php';

class add_workflow_insertFieldscbProcessStep extends cbupdaterWorker {

	public function applyChange() {
		if ($this->hasError()) {
			$this->sendError();
		}
		if ($this->isApplied()) {
			$this->sendMsg('Changeset '.get_class($this).' already applied!');
		} else {
			if (vtlib_isModuleActive('cbProcessStep')) {
				$module = Vtiger_Module::getInstance('cbProcessStep');
				$block = Vtiger_Block::getInstance('LBL_CBPROCESSSTEP_INFORMATION', $module);
				$field = Vtiger_Field::getInstance('casefrom', $module);
				if (!$field) {
					$field1 = new Vtiger_Field();
					$field1->name = 'casefrom';
					$field1->label= 'casefrom';
					$field1->column = 'casefrom';
					$field1->columntype = 'VARCHAR(155)';
					$field1->uitype = 1;
					$field1->typeofdata = 'V~O';
					$field1->displaytype = 4;
					$field1->presence = 0;
					$block->addField($field1);
				}
				$field = Vtiger_Field::getInstance('caseto', $module);
				if (!$field) {
					$field1 = new Vtiger_Field();
					$field1->name = 'caseto';
					$field1->label= 'caseto';
					$field1->column = 'caseto';
					$field1->columntype = 'VARCHAR(155)';
					$field1->uitype = 1;
					$field1->typeofdata = 'V~O';
					$field1->displaytype = 4;
					$field1->presence = 0;
					$block->addField($field1);
				}
				cbProcessStep::addWorkFlowCaseFields();
				$this->sendMsg('Changeset '.get_class($this).' applied!');
				$this->markApplied(false);
				$this->finishExecution();
			}
		}
	}
}