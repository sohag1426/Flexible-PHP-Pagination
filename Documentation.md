<h1 class="entry-title">Flexible PHP Pagination Documentation</h1>
					
<p>The pagination class was designed to make PHP pagination easier without sacrificing any of the possibilities.</p>
<p>Flexible PHP Pagination can be used to paginate any type of data set, any Languages, it supports any type of HTML structure, any type of SEO Link Structure. And much more, no longer are you bound by the rules or complexities that Pagination presents.</p>

<h2 id="toc" class="alt">Table of Contents</h2>
<ol class="alpha">
<li><a href="#a">Description</a></li>
<li><a href="#b">Installation</a></li>
<li><a href="#c">Basic Usage</a></li>
<li><a href="#d">Full Flexibility</a></li>
<li><a href="#e">Final Notes</a></li>
</ol>

<hr class="dotted" />

<h3 id="a"><strong>Description</strong> &#8211; <a href="#toc">top</a></h3>

<p>This script does not have CSS Styles and Preselected Display Styles. In other words, the pagination can fit your design, or custom format.</p>

<hr class="dotted" />

<h3 id="b"><strong>Installation</strong> &#8211; <a href="#toc">top</a></h3>

<p>This is a basic PHP Class. So to use this, all you have to do is the following:</p>

<ul>
<li>Download and Unzip File</li>
<li>Copy <strong>pagination.php</strong> to your directory of choosing.</li>
<li>Use PHP to include the file.</li>
</ul>

<p>Because of this class&#8217;s Flexibility, it may be harder to understand how to use it, but we assume Basic Knowledge of PHP is present. A file include would go as followed:</p>

<pre>include('classes/pagination.php');</pre>

<hr class="dotted" />
<h3 id="c"><strong>Basic Usage</strong> &#8211; <a href="#toc">top</a></h3>

<p>Before you can paginate information, you must understand how pagination works. Any type of Pagination requires a minimum of <strong>2 parameters</strong> and <strong>1 optional parameter</strong>.</p>

<ul>
<li>Maxmum Results Per Page</li>
<li>Total Number of Results from your Data Source</li>
<li>Optional: A $_GET parameter name, defaults to &#8216;p&#8217;</li>
</ul>

<p>The Pagination Class is Generic, this means is that we use Pagination without a Data Source (like MySQL for example). That allows you to paginate any data sources you may have.</p>
<p>Basic Setup Example:</p>

<pre>// Connect To Database - Edit Details for your own Database
mysql_connect('localhost', 'root', 'root');
mysql_select_db('test');

// Include Pagination Class
include('pagination.php');</pre>

<p>Maximum Per Page, Total number of results and optionally a Get Parameter.</p>

<pre>// Maximum Items Per Page
$max = 6;

// Number of Total Results in our Table
$numQuery = mysql_query("SELECT * FROM test") or die( mysql_error() ); 
$total = mysql_num_rows($numQuery);

// We Need to know for pagination, our Maximum per page, and our Total, and an optional Parameter
$nav = new Pagination($max, $total, 'page');

// Here we run the Query and Limit our Results based on the pagination
$query = mysql_query("SELECT * FROM test LIMIT ".$nav->start().",".$max) or die( mysql_error() ); 
while($result = mysql_fetch_object($query))
{
	echo $result->title . ' &lt;br&gt; ' . $result->article ; 
}

// Show the Previous Link, Custom HTML is accepted
echo $nav->previous(' &lt;a href="index.php?page={nr}"&gt;Previous&lt;/a&gt; | ');

// Show the Numbers, Custom HTML is accepted
// Parameter1: For Loop Number with a Link
// Parameter2: Loop Number of Current Page (no link)
echo $nav->numbers(' &lt;a href="index.php?page={nr}"&gt;{nr}&lt;/a&gt; | ', ' &lt;b&gt;{nr}&lt;/b&gt; | ');

// Show the Previous Link, Custom HTML is accepted
echo $nav->next(' &lt;a href="index.php?page={nr}"&gt;Next&lt;/a&gt; | ');
</pre>

<p>That&#8217;s right there is to it. You may have noticed we allow custom HTML. This gives you full flexibility. We have integrated an easy system that allows you to access information you need to design your own custom Navigation. Here we will list all possible combinations.</p>

<strong>Link Functions List:</strong>

<ul>
<li>$obj->first( active, inactive )</li>
<li>$obj->previous( active, inactive )</li>
<li>$obj->next( active, inactive )</li>
<li>$obj->last( active, inactive )</li>
<li>$obj->info( html )</li>
<li>$obj->numbers( link, current, reversed = 0 )</li>
</ul>

<p>Active refers to custom HTML for the Active Link. Inactive is optional HTML and when ignored the link simply will not display. However, if you want to show an Inactive link. You can use the HTML there to display an  Inactive Link. As you can see our Functions most of the time work exactly the same, when you call $obj->previous and use {nr} it wil display the previous number. There is one exeption that allows multiple inputs, this one is for the numbers itself.</p>

<p>The $obj->numbers accepts 3 parameters. Each have their own use.</p>

<strong>Numbers Method:</strong>

<dl class="separator">

<dt>Parameter 1</dt>
<dd>Required &#8211; a number WITH A LINK. This is used for all numbers except for the current page</dd>

<dt>Parameter 2</dt>
<dd>Required &#8211; a number WITHOUT A LINK. This is used for the current page you are on</dd>

<dt>Parameter 3</dt>
<dd>Optional &#8211; this accepts only 0 and 1. When set to 1 it will reverse <u>only the order of the numbers</u> backwards.</dd>

</dl>

<p>Next up are tags. Because we wanted to make it easy to use we added easy to use tags. Much like template engines use them. There are only the tags we created and they are <strong>Case Sensetive</strong>.</p>

<strong>Tag List:</strong>

<dl class="separator">

<dt>{nr}</dt>
<dd>Returns the appropriate number for the function. Works in all functions</dd>

<dt>{page}</dt>
<dd>Returns the current page you are on &#8211; Only in $obj->info();</dd>

<dt>{pages}</dt>
<dd>Returns the total number of pages &#8211; Only in $obj->info();</dd>

<dt>{start}</dt>
<dd>Returns the start of your result set within a page &#8211; Only in $obj->info();</dd>

<dt>{end}</dt>
<dd>Returns the end of your result set within a page &#8211; Only in $obj->info();</dd>

<dt>{total}</dt>
<dd>Returns the total number of results &#8211; Only in $obj->info();</dd>

</dl>

<p>The method $obj->info(); allows a lot more tags then the others. This method was specifically designed to return these particular results so you can use this function multiple times. For example if your pagination is in seperated divs etc. Here is an example usage of the info method:</p>

<pre>echo $nav->info(' Page {page} of {pages} | ');

echo $nav->info(' Result {start} to {end} of {total} | ');</pre>

<hr class="dotted" />

<h3 id="d"><strong>Full Flexibility</strong> &#8211; <a href="#toc">top</a></h3>

<p>Here are some examples of how you can use this Pagination class in different ways.</p>

<p><strong>Full Pagination:</strong></p>

<pre>// Show the First Link
echo $nav->first(' &lt;a href="file.php?page={nr}"&gt;First&lt;/a&gt; | ');

// Show the Previous Link
echo $nav->previous(' &lt;a href="file.php?page={nr}"&gt;Previous&lt;/a&gt; | ');

// Show Numbers
echo $nav->numbers(' &lt;a href="file.php?page={nr}"&gt;{nr}&lt;/a&gt; | ', ' &lt;b&gt;{nr}&lt;/b&gt; | ');

// Show the Next Link
echo $nav->next(' &lt;a href="file.php?page={nr}"&gt;Next&lt;/a&gt; | ');

// Show the Last Link
echo $nav->last(' &lt;a href="file.php?page={nr}"&gt;Last&lt;/a&gt; | ');

echo $nav->info(' Page {page} of {pages} | ');
echo $nav->info(' Result {start} to {end} of {total} | ');</pre>

<p><strong>Search Engine Optimized Links:</strong></p>
<pre>    // Show the First Link
echo $nav->first(' &lt;a href="./page-{nr}/"&gt;First&lt;/a&gt; | ');

// Show the Previous Link
echo $nav->previous(' &lt;a href="./page-{nr}/"&gt;Previous&lt;/a&gt; | ');

// Show Numbers
echo $nav->numbers(' &lt;a href="./page-{nr}/"&gt;{nr}&lt;/a&gt; | ', ' &lt;b&gt;{nr}&lt;/b&gt; | ');

// Show the Next Link
echo $nav->next(' &lt;a href="./page-{nr}/"&gt;Next&lt;/a&gt; | ');

// Show the Last Link
echo $nav->last(' &lt;a href="./page-{nr}/"&gt;Last&lt;/a&gt; | ');</pre>

<p><strong>Custom Styled HTML:</strong></p>

<pre>// That's right, if we want to we can display this information before we show the links.
echo $nav->info('&lt;div id="result-info"&gt; Result {start} to {end} of {total} &lt;/div&gt;');

// Show the First Link
echo $nav->first('&lt;div id="first"&gt; &lt;a href="index.php?p={nr}"&gt;First&lt;/a&gt; &lt;/div&gt;');

// Show the Previous Link
echo $nav->previous('&lt;div id="previous"&gt; &lt;a href="index.php?p={nr}"&gt;Previous&lt;/a&gt; &lt;/div&gt;');

// Show Numbers
echo $nav->numbers('&lt;div id="number"&gt; &lt;a href="index.php?p={nr}"&gt;{nr}&lt;/a&gt;', ' &lt;div id="current"&gt;{nr}&lt;/div&gt;');

// Show the Next Link
echo $nav->next('&lt;div id="next"&gt; &lt;a href="index.php?p={nr}"&gt;Next&lt;/a&gt; &lt;/div&gt;');

// Show the Last Link
echo $nav->last('&lt;div id="last"&gt; &lt;a href="index.php?p={nr}"&gt;Last&lt;/a&gt; &lt;/div&gt;');
echo $nav->info('&lt;div id="page-info"&gt; Page {page} of {pages} &lt;/div&gt;');</pre>

<p><strong>Reversed Numbers:</strong></p>
<pre>echo $nav->numbers(' &lt;a href="index.php?p={nr}"&gt;{nr}&lt;/a&gt; | ', ' &lt;b&gt; {nr} &lt;/b&gt;', 1);</pre>

<p><strong>Translated Text:</strong></p>
<pre>// Show the First Link
echo $nav->first(' &lt;a href="./page-{nr}/"&gt;Begin&lt;/a&gt; | ');

// Show the Previous Link
echo $nav->previous(' &lt;a href="./page-{nr}/"&gt;Vorige&lt;/a&gt; | ');

// Show Numbers
echo $nav->numbers(' &lt;a href="./page-{nr}/"&gt;{nr}&lt;/a&gt; | ', ' &lt;b&gt;{nr}&lt;/b&gt; | ');

// Show the Next Link
echo $nav->next(' &lt;a href="./page-{nr}/"&gt;Volgende&lt;/a&gt; | ');

// Show the Last Link
echo $nav->last(' &lt;a href="./page-{nr}/"&gt;Einde&lt;/a&gt; | ');</pre>

<hr class="dotted" />

<h3 id="e"><strong>Final Notes</strong> &#8211; <a href="#toc">top</a></h3>

<p>Reconnect is always glad to help you if you have any questions relating to this product.</p> 

<p><a href="#toc">Go To Table of Contents</a></p>