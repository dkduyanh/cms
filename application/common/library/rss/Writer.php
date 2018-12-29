<?php

namespace app\library\rss;

/**
 * Class RSS Writer
 * @author DuyAnh
 * Read more at: http://cyber.law.harvard.edu/rss/rss.html
 *
 */
class Writer{
	/**
	 * The name of the channel.
	 * @var string
	 */
	protected $title;
	
	/**
	 * The URL to the website corresponding to the channel.
	 * @var string
	 */
	protected $link;
	
	/**
	 * Phrase or sentence describing the channel.
	 * @var string
	 */
	protected $description;
	
	/**
	 * The language the channel is written in.
	 * @var string
	 */
	protected $language;
	
	/**
	 * Copyright notice for content in the channel.
	 * @var string
	 */
	protected $copyright;
	
	/**
	 * The publication date for the content in the channel.
	 * @var int
	 */
	protected $pubDate;
	
	/**
	 * The last time the content of the channel changed.
	 * @var int
	 */
	protected $lastBuildDate;
	
	/**
	 * Specify one or more categories that the channel belongs to
	 * @var array
	 */
	protected $categories = [];
	
	/**
	 * A string indicating the program used to generate the channel.
	 * @var string
	 */
	protected $generator;
	
	/**
	 * Specifies a GIF, JPEG or PNG image that can be displayed with the channel. which contains three required and three optional sub-elements.
	 * <url> is the URL of a GIF, JPEG or PNG image that represents the channel.
	 * <title> describes the image, it's used in the ALT attribute of the HTML <img> tag when the channel is rendered in HTML.
	 * <link> is the URL of the site, when the channel is rendered, the image is a link to the site.
	 * Optional elements include:
	 * <width> and <height>, numbers, indicating the width and height of the image in pixels.
	 * <description> contains text that is included in the TITLE attribute of the link formed around the image in the HTML rendering.
	 * @var array
	 */
	protected $image;
	
	/**
	 * List of items
	 * @var array
	 */
	protected $items = [];
	
	/**
	 * Set name of the channel. (Required)
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
		return $this;
	}
	
	/**
	 * Set URL to the website corresponding to the channel. (Required)
	 * @param string $link
	 */
	public function setLink($link)
	{
		$this->link = $link;
		return $this;
	}
	
	/**
	 * Set summary of the channel. (Required)
	 * @param string $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
		return $this;
	}
	
	/**
	 * Set language the channel is written in. (Optional)
	 * @param string $language
	 */
	public function setLanguage($language)
	{
		$this->language = $language;
		return $this;
	}
	
	/**
	 * Set copyright notice for content in the channel. (Optional)
	 * @param string $copyright
	 */
	public function setCopyright($copyright)
	{
		$this->copyright = $copyright;
		return $this;
	}
	
	/**
	 * Set the publication date for the content in the channel. (Optional)
	 * @param int $pubDate
	 */
	public function setPubDate($pubDate)
	{
		$this->pubDate = $pubDate;
		return $this;
	}
	
	/**
	 * Set the last time the content of the channel changed. (Optional)
	 * @param int $lastBuildDate
	 */
	public function setLastBuildDate($lastBuildDate)
	{
		$this->lastBuildDate = $lastBuildDate;
		return $this;
	}
	
	/**
	 * Specify one or more categories that the channel belongs to. (Optional)
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
	 * Set the program used to generate the channel. (Optional)
	 * @param string $generator
	 */
	public function setGenerator($generator)
	{
		$this->generator = $generator;
		return $this;
	}
	
	/**
	 * Set a GIF, JPEG or PNG image that can be displayed with the channel. (Optional)
	 * @param string $url is the URL of a GIF, JPEG or PNG image that represents the channel.
	 * @param string $title describes the image, it's used in the ALT attribute of the HTML img tag when the channel is rendered in HTML. This element SHOULD have the same text as the channel's title element.
	 * @param string $link is the URL of the site, when the channel is rendered, the image is a link to the site.
	 * @param number $width (Optional) indicating the width of the image in pixels. Maximum value for width is 144, default value is 88. 
	 * @param number $height (Optional) indicating the height of the image in pixels. Maximum value for height is 400, default value is 31.
	 * @param string $description (Optional) contains text that is included in the TITLE attribute of the link formed around the image in the HTML rendering.
	 * @return \app\models\rss\Writer
	 */
	public function setImage($url, $title, $link, $width = 88, $height = 31, $description = '')
	{
		$this->image = ['url' => $url, 'title' => $title, 'link' => $link, 'width' => $width, 'height' => $height, 'description' => $description];
		return $this;
	}
	
	/**
	 * Add items to channel.
	 * @param Item $item
	 */
	public function addItem(Item $item)
	{
		$this->items[] = $item;
		return $this;
	}

	/**
	 * Render RSS as XML
	 * @return string
	 */
	public function asXML()
	{
		$dom = new \DOMDocument("1.0", "UTF-8"); // Create new DOM document.
		
		//create "RSS" element
		$rss = $dom->createElement("rss");
		$rss_node = $dom->appendChild($rss); //add RSS element to XML node
		$rss_node->setAttribute("version","2.0"); //set RSS version
		
		//create "Channel" element
		$channel = $dom->createElement("channel");
		$channel_node = $rss_node->appendChild($channel); //add Channel element to RSS node
		
		//add general elements under "channel" node
		//required elements
		$channel_node->appendChild($dom->createElement("title", htmlspecialchars($this->title)));
		$channel_node->appendChild($dom->createElement("link", htmlspecialchars($this->link)));
		$channel_node->appendChild($dom->createElement("description", htmlspecialchars($this->description)));
		
		//optional elements
		if(isset($this->language)){
			$channel_node->appendChild($dom->createElement("language", htmlspecialchars($this->language)));
		}
		if(isset($this->copyright)){
			$channel_node->appendChild($dom->createElement("copyright", htmlspecialchars($this->copyright)));
		}
		if(isset($this->pubDate)){
			$channel_node->appendChild($dom->createElement("pubDate", date(DATE_RSS, $this->pubDate)));
		}
		if(isset($this->lastBuildDate)){
			$channel_node->appendChild($dom->createElement("lastBuildDate", date(DATE_RSS, $this->lastBuildDate)));
		}
		if(!empty($this->categories) && is_array($this->categories)){
			foreach($this->categories as $category){
				$element = $dom->createElement("category", htmlspecialchars($category[0]));
				if(isset($category[1])){
					$element->setAttribute('domain', htmlspecialchars($category[1]));
				}
				$channel_node->appendChild($element);
			}
		}
		if(is_array($this->image) && count($this->image) == 6){
			$element = $dom->createElement('image');
			$element->appendChild($dom->createElement('url', htmlspecialchars($this->image['url'])));
			$element->appendChild($dom->createElement('title', htmlspecialchars($this->image['title'])));
			$element->appendChild($dom->createElement('link', htmlspecialchars($this->image['link'])));
			if (!empty($this->image['width'])) {
				$element->appendChild($dom->createElement('width', htmlspecialchars($this->image['width'])));
			}
			if (!empty($this->image['height'])) {
				$element->appendChild($dom->createElement('height', htmlspecialchars($this->image['height'])));
			}
			if (!empty($this->image['description'])) {
				$element->appendChild($dom->createElement('description', htmlspecialchars($this->image['description'])));
			}
			$channel_node->appendChild($element);
		}
		if(isset($this->generator)){
			$channel_node->appendChild($dom->createElement("generator", htmlspecialchars($this->generator)));
		}
		
		//add items
		foreach($this->items as $item){			
 			//OPTION 1: use DOMDocument
 			/*$item_doc = new \DOMDocument();
 			$item_doc->loadXML($item);
 			$item_node_org = $item_doc->getElementsByTagName("item")->item(0);

 			$item_node = $dom->importNode($item_node_org, true);
 			$channel_node->appendChild($item_node); */
 			
			//OPTION 2: use SimpleXMLElement
			$xml = new \SimpleXMLElement($item->asXML());
 			$item_node = dom_import_simplexml($xml);
 			$channel_node->appendChild($dom->importNode($item_node, true));
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