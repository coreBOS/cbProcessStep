<?php
/*************************************************************************************************
 * Copyright 2022 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Customizations.
 * Licensed under the vtiger CRM Public License Version 1.1 (the "License"); you may not use this
 * file except in compliance with the License. You can redistribute it and/or modify it
 * under the terms of the License. JPL TSolucio, S.L. reserves all rights not expressly
 * granted by the License. coreBOS distributed by JPL TSolucio S.L. is distributed in
 * the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. Unless required by
 * applicable law or agreed to in writing, software distributed under the License is
 * distributed on an "AS IS" BASIS, WITHOUT ANY WARRANTIES OR CONDITIONS OF ANY KIND,
 * either express or implied. See the License for the specific language governing
 * permissions and limitations under the License. You may obtain a copy of the License
 * at <http://corebos.org/documentation/doku.php?id=en:devel:vpl11>
 *************************************************************************************************/
class addLabelAndUserMap extends cbupdaterWorker {

	public function applyChange() {
		if ($this->hasError()) {
			$this->sendError();
		}
		if ($this->isApplied()) {
			$this->sendMsg('Changeset '.get_class($this).' already applied!');
		} else {
			$modname = 'cbProcessStep';
			$module = Vtiger_Module::getInstance($modname);
			$block = Vtiger_Block::getInstance('LBL_CBPROCESSSTEP_INFORMATION', $module);
			$field = Vtiger_Field::getInstance('buttonlabel', $module);
			if ($field) {
				$this->ExecuteQuery('update vtiger_field set presence=2 where fieldid=?', array($field->id));
			} else {
				$fieldInstance = new Vtiger_Field();
				$fieldInstance->name = 'buttonlabel';
				$fieldInstance->label = 'Button Label';
				$fieldInstance->columntype = 'varchar(153)';
				$fieldInstance->uitype = 1;
				$fieldInstance->displaytype = 1;
				$fieldInstance->typeofdata = 'V~O';
				$fieldInstance->quickcreate = 0;
				$block->addField($fieldInstance);
			}
			$field = Vtiger_Field::getInstance('usermap', $module);
			if ($field) {
				$this->ExecuteQuery('update vtiger_field set presence=2 where fieldid=?', array($field->id));
			} else {
				$fieldInstance = new Vtiger_Field();
				$fieldInstance->name = 'usermap';
				$fieldInstance->label = 'New User/Group ID Map';
				$fieldInstance->columntype = 'int(11)';
				$fieldInstance->uitype = 10;
				$fieldInstance->displaytype = 1;
				$fieldInstance->typeofdata = 'V~O';
				$fieldInstance->quickcreate = 0;
				$block->addField($fieldInstance);
				$fieldInstance->setRelatedModules(['cbMap']);
			}
			$field = Vtiger_Field::getInstance('assignuserafter', $module);
			if ($field) {
				$this->ExecuteQuery('update vtiger_field set presence=2 where fieldid=?', array($field->id));
			} else {
				$fieldInstance = new Vtiger_Field();
				$fieldInstance->name = 'assignuserafter';
				$fieldInstance->label = 'Assign User/Group After';
				$fieldInstance->columntype = 'varchar(3)';
				$fieldInstance->uitype = 56;
				$fieldInstance->displaytype = 1;
				$fieldInstance->typeofdata = 'C~O';
				$fieldInstance->quickcreate = 0;
				$fieldInstance->default = 1;
				$block->addField($fieldInstance);
			}
			$this->sendMsg('Changeset '.get_class($this).' applied!');
			$this->markApplied();
		}
		$this->finishExecution();
	}
}
?>
