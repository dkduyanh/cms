<?php

namespace app\library\rss;

/**
 * Class RSS Item
 * @author DuyAnh
 * Read more at: http://cyber.law.harvard.edu/rss/rss.html
 *
 */

class Item{
	/**
	 * The title of the item.
	 * @var string
	 */
	protected $title;
	
	/**
	 * The URL of the item.
	 * @var string
	 */
	protected $link;
	
	/**
	 * Summary of the item.
	 * @var string
	 */
	protected $description;
	
	/**
	 * Encoding description within a CDATA Section
	 * @var boolean
	 */
	protected $cdata;
	
	/**
	 * Email address of the author of the item.
	 * @var string
	 */
	protected $author;
	
	/**
	 * Includes the item in one or more categories.
	 * It has one optional attribute, domain, a string that identifies a categorization taxonomy.
	 * You may include as many category elements as you need to, for different domains
	 * @var array
	 */
	protected $categories = [];
	
	/**
	 * URL of a page for comments relating to the item.
	 * @var string
	 */
	protected $comments;

	/**
	 * Describes a media object that is attached to the item.
	 * It has three required attributes.
	 * 		URL (must be an http url) says where the enclosure is located,
	 * 		LENGTH says how big it is in bytes,
	 * 		and TYPE says what its type is, a standard MIME type.
	 * It is recommended that only one <enclosure> element is included per <item>
	 * See more at: http://www.rssboard.org/rss-profile#element-channel-item-enclosure
	 * @var array
	 */
	protected $enclosure;
	
	/**
	 * A string of character that is unique to designate this item.
	 * @var string
	 */
	protected $guid;
	
	/**
	 * If the guid element has an attribute named "isPermaLink" with a value of true, the reader may assume that it is a permalink to the item, that is, a url that can be opened in a Web browser, that points to the full item described by the <item> element
	 * @var boolean
	 */
	protected $isPermalink;
	
	/**
	 * Indicates when the item was published
	 * @var int
	 */
	protected $pubDate;
	
	/**
	 * Set title of the item. (Required)
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
		return $this;
	}
	
	/**
	 * Set URL of the item. (Required)
	 * @param string $link
	 */
	public function setLink($link)
	{
		$this->link = $link;
		return $this;
	}
	
	/**
	 * Set summary of the item. (Required)
	 * @param string $description
	 * @param string $cdata Encoding description within a CDATA Section
	 */
	public function setDescription($description, $cdata = false)
	{
		$this->description = $description;		
		$this->cdata = $cdata;
		return $this;
	}
	
	/**
	 * Set author of the item. (Optional)
	 * @param string $author
	 */
	public function setAuthor($author)
	{
		$this->author = $author;
		return $this;
	}
	
	/**
	 * Set category of item. (Optional)
	 * You may include as many category elements as you need to, for different domains
	 * @param string $name
	 * @param string $domain
	 */
	public function setCategory($name, $domain = null)
	{
		$this->categories[] = [$name, $domain];
		return $this;
	}
	
	/**
	 * Set URL of a page for comments relating to the item. (Optional)
	 * @param string $comments
	 */
	public function setComments($comments)
	{
		$this->comments = $comments;
		return $this;
	}
	
	/**
	 * Set media object that is attached to the item. (Optional)
	 * @param string $url (must be an http url) says where the enclosure is located
	 * @param int $length says how big it is in bytes
	 * @param string $type says what its type is, a standard MIME type
	 */
	public function setEnclosure($url, $length, $type)
	{
		$this->enclosure = ['url' => $url, 'length' => $length, 'type' => $type];
		return $this;
	}
	
	/**
	 * Set a string that uniquely identifies the item. (Optional)
	 * @param string $guid
	 * @param boolean $isPermalink
	 */
	public function setGuid($guid, $isPermalink = false)
	{
		$this->guid = $guid;
		$this->isPermalink = $isPermalink;
		return $this;
	}
	
	/**
	 * Set date when the item was published. (Optional)
	 * @param int $pubDate
	 */
	public function setPubDate($pubDate)
	{
		$this->pubDate = $pubDate;
		return $this;
	}
	
	/**
	 * Render item as XML
	 * @return string
	 */
	public function asXML(){		
		$dom = new \DOMDocument("1.0", "UTF-8"); // Create new DOM document.
		
		//create "ITEM" element
		$item = $dom->createElement("item");
		$item_node = $dom->appendChild($item); //add ITEM element to XML node
		
		//Required elements
		
		//title
		$item_node->appendChild($dom->createElement("title", htmlspecialchars($this->title)));
		
		//link
		$item_node->appendChild($dom->createElement("link", htmlspecialchars($this->link)));
		
		//description
		if(isset($this->cdata) && $this->cdata === true){
			$element = $dom->createElement("description");
			$element->appendChild($dom->createCDATASection($this->description));
			$item_node->appendChild($element);			
		}
		else {
			$item_node->appendChild($dom->createElement("description", htmlspecialchars($this->description)));
		}
		
		//Optional elements
		
		//author
		if(isset($this->author)){
			$item_node->appendChild($dom->createElement("author", htmlspecialchars($this->author)));
		}
		
		//category
		if(!empty($this->categories) && is_array($this->categories)){
			foreach($this->categories as $category){
				$element = $dom->createElement("category", htmlspecialchars($category[0]));				
				if(isset($category[1])){
					$element->setAttribute('domain', htmlspecialchars($category[1]));
				}
				$item_node->appendChild($element);
			}
		}
		
		//comments
		if(isset($this->comments))
		{
			$item_node->appendChild($dom->createElement("author", htmlspecialchars($this->comments)));
		}
		
		//enclosure
		if (is_array($this->enclosure) && (count($this->enclosure) == 3)) {
			$element = $dom->createElement('enclosure');
			$element->setAttribute('url', htmlspecialchars($this->enclosure['url']));
			$element->setAttribute('type', htmlspecialchars($this->enclosure['type']));		
			if ($this->enclosure['length']) {
				$element->setAttribute('length', htmlspecialchars($this->enclosure['length']));
			}
			$item_node->appendChild($element);
		}
		
		//guid
		if ($this->guid) {
			$element = $dom->createElement("guid", htmlspecialchars($this->guid));
			if (isset($this->isPermalink)) {
				$element->setAttribute('isPermaLink', ($this->isPermalink == false ? 'false' : 'true'));
			}
			$item_node->appendChild($element);
		}
		
		//pubDate
		if(!empty($this->pubDate)){
			$item_node->appendChild($dom->createElement("pubDate", date(DATE_RSS, $this->pubDate)));
		}
		
		return $dom->saveXML();
	}
	
	/**
     * Convert item to xml, an alias of asXML()
     * @return string
     */
	public function __toString(){
		return $this->asXML();
	}
}