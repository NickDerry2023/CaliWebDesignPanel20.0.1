<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

namespace Google\Service\Aiplatform;

class LearningGenaiRecitationSegmentResult extends \Google\Model
{
  /**
   * @var string
   */
  public $attributionDataset;
  /**
   * @var string
   */
  public $displayAttributionMessage;
  protected $docAttributionType = LearningGenaiRecitationDocAttribution::class;
  protected $docAttributionDataType = '';
  /**
   * @var int
   */
  public $docOccurrences;
  /**
   * @var int
   */
  public $endIndex;
  /**
   * @var string
   */
  public $rawText;
  /**
   * @var string
   */
  public $segmentRecitationAction;
  /**
   * @var string
   */
  public $sourceCategory;
  /**
   * @var int
   */
  public $startIndex;

  /**
   * @param string
   */
  public function setAttributionDataset($attributionDataset)
  {
    $this->attributionDataset = $attributionDataset;
  }
  /**
   * @return string
   */
  public function getAttributionDataset()
  {
    return $this->attributionDataset;
  }
  /**
   * @param string
   */
  public function setDisplayAttributionMessage($displayAttributionMessage)
  {
    $this->displayAttributionMessage = $displayAttributionMessage;
  }
  /**
   * @return string
   */
  public function getDisplayAttributionMessage()
  {
    return $this->displayAttributionMessage;
  }
  /**
   * @param LearningGenaiRecitationDocAttribution
   */
  public function setDocAttribution(LearningGenaiRecitationDocAttribution $docAttribution)
  {
    $this->docAttribution = $docAttribution;
  }
  /**
   * @return LearningGenaiRecitationDocAttribution
   */
  public function getDocAttribution()
  {
    return $this->docAttribution;
  }
  /**
   * @param int
   */
  public function setDocOccurrences($docOccurrences)
  {
    $this->docOccurrences = $docOccurrences;
  }
  /**
   * @return int
   */
  public function getDocOccurrences()
  {
    return $this->docOccurrences;
  }
  /**
   * @param int
   */
  public function setEndIndex($endIndex)
  {
    $this->endIndex = $endIndex;
  }
  /**
   * @return int
   */
  public function getEndIndex()
  {
    return $this->endIndex;
  }
  /**
   * @param string
   */
  public function setRawText($rawText)
  {
    $this->rawText = $rawText;
  }
  /**
   * @return string
   */
  public function getRawText()
  {
    return $this->rawText;
  }
  /**
   * @param string
   */
  public function setSegmentRecitationAction($segmentRecitationAction)
  {
    $this->segmentRecitationAction = $segmentRecitationAction;
  }
  /**
   * @return string
   */
  public function getSegmentRecitationAction()
  {
    return $this->segmentRecitationAction;
  }
  /**
   * @param string
   */
  public function setSourceCategory($sourceCategory)
  {
    $this->sourceCategory = $sourceCategory;
  }
  /**
   * @return string
   */
  public function getSourceCategory()
  {
    return $this->sourceCategory;
  }
  /**
   * @param int
   */
  public function setStartIndex($startIndex)
  {
    $this->startIndex = $startIndex;
  }
  /**
   * @return int
   */
  public function getStartIndex()
  {
    return $this->startIndex;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(LearningGenaiRecitationSegmentResult::class, 'Google_Service_Aiplatform_LearningGenaiRecitationSegmentResult');
