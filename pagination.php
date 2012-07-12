<?
/**
 * example of using @return with a class name
 * @param integer even or odd integer
 * @return Parser|false phpDocumentor Parser object or error
 */
class Pagination
{
    var $max, $total, $parameter, $start = 0;
    var $i = 0;
    
   /**
    * Class Constructor, Accepts 3 parameters. The minimum that any pagination requires.
    * @param int $max maximum amount of results per page
    * @param int $total total number of results in data source
    * @param int $parameter Default $_GET[param], where parameter will be replaced
    */
    function Pagination($max, $total, $parameter = 'p')
    { 
        $this->max      = $max; 
        $this->total    = $total;
        $this->parameter = $parameter;
        
        $this->get = !empty( $_GET[$this->parameter] ) ? $_GET[$this->parameter] : 1;
    }
    
   /**
    * This calculates the start of our result set, based on our current page
    * @return int Final Calculation of where our result set should begin
    */
    function start()
    {
        // Computers Calculate From 0 thus, page1 must start results from 0
        $start = $this->get-1;
        
        // Calculate Our Starting Point (0x6=0(start from 0, page1), 1x6=6(start from 6, page2), etc)
        $calc = $start*$this->max;
        
        // return our final outcome
        return $calc;
    }
    
   /**
    * This calculates the end of our result set, based on our current page
    * @return int Final Calculation of where our result set should end
    */
    function end()
    {
        // Calculate the Beginning + The maximum amount of results
        $calc = $this->start() + $this->max;
        
        // Only return this if it is not above the total otherwise return our maximum
        // example, 24 + 6 = 30, but with only 26 reselts it will display the total results istead (26)
        $r = ($calc > $this->total) ? $this->total : $calc;
        
        // return the result
        return $r;
    }
    
   /**
    * This calculates the total pages in our result set
    * @return int return Rounds Up the total results / maximum per page
    */
    function pages()
    {
        return ceil($this->total/$this->max);
    }
    
   /**
    * Based on which page you are this returns informations like, start result, end result, total results, current page, total pages
    * @param string $html The HTML you wish to use to display the link
    * @return mixed return information we may need to display
    */
    function info($html)
    {
        $tags = array('{total}', '{start}', '{end}', '{page}', '{pages}');
        $code = array($this->total, $this->start()+1, $this->end(), $this->get, $this->pages());
        
        return str_replace($tags, $code, $html);
    }
    
   /**
    * This shows the 'first' link with custom html
    * @param string $html The HTML you wish to use to display the link
    * @return string The Same HTML replaced the tags with the proper number
    */
    function first($html, $html2='')
    {
        // Only show if you are not on page 1, otherwise show HTML2
        $r = ($this->get != 1) ? str_replace('{nr}', 1, $html) : str_replace('{nr}', 1, $html2);
        
        return $r;
    }
    
   /**
    * This shows the 'previous' link with custom html
    * @param string $html The HTML you wish to use to display the link
    * @return string The Same HTML replaced the tags with the proper number
    */
    function previous($html, $html2='')
    {
        // Only show if you are not on page 1, otherwise show HTML2
        $r = ($this->get != 1) ? str_replace('{nr}', $this->get-1, $html) : str_replace('{nr}', $this->get-1, $html2);
        
        return $r;
    }
    
   /**
    * This shows the 'next' link with custom html
    * @param string $html The HTML you wish to use to display the link
    * @return string The Same HTML replaced the tags with the proper number
    */
    function next($html, $html2='')
    {
        // Only show if you are not on the last page
        $r = ($this->get < $this->pages()) ? str_replace('{nr}', $this->get+1, $html) : str_replace('{nr}', $this->get+1, $html2);
        
        return $r;
    }
    
   /**
    * This shows the 'last' link with custom html
    * @param string $html The HTML you wish to use to display the link
    * @return string The Same HTML replaced the tags with the proper number
    */
    function last($html, $html2='')
    {
        // Only show if you are not on the last page
        $r = ($this->get < $this->pages()) ? str_replace('{nr}', $this->pages(), $html) : str_replace('{nr}', $this->pages(), $html2);
        
        return $r;
    }
    
   /**
    * This shows an loop of 'numbers' with their appropriate link in custom html
    * @param string $link The HTML to display a number with a link
    * @param string $current The HTML to display a the current page number without a link
    * @param string $loop Optional Parameter, set to 1 if you want the numbers reversed (align to right for designs)
    * @return string The Same HTML replaced the tags with the proper numbers and links
    */
    function numbers($link, $current, $loop=0)
    {
        $r = '';
        
        if($loop == 0)
        {
            for($i = 1; $i <= $this->pages(); $i++)
            {
                if($this->get == $i)
                {
                    $r .= str_replace('{nr}', $i, $current);
                }
                else
                {
                    $r .= str_replace('{nr}', $i, $link);
                }
            }
        }
        elseif($loop == 1)
        {
            for($i = $this->pages(); $i >= 1; $i--)
            {
                if($this->get == $i)
                {
                    $r .= str_replace('{nr}', $i, $current);
                }
                else
                {
                    $r .= str_replace('{nr}', $i, $link);
                }
            }
        }
		
		return $r;
    }
	
    /**
     * This function allows you to limit the loop without using a limit inside another query. Or if you are using arrays / xml.
     */
    function paginator()
    {
        $this->i = $this->i+1;
        if( $this->i > $this->start() && $this->i <= $this->end() )
        {
            return true;
        }
    }
}
