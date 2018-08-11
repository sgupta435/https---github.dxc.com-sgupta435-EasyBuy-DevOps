<?xml version="1.0" encoding="ISO-8859-1"?>
<!-- Edited with XML Spy v2006 (http://www.altova.com) -->
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template match="/">
   <table width="100%" border="1" cellpadding="0" cellspacing="0"  id="results">
   <thead>
      <tr>
                <td width="7%" class="header"><div>Rank Number</div></td>
		<td width="7%" class="header"><div>Product Number</div></td>
		<td width="9%" class="header"><div>Ezb Display Exclusion</div></td>
	        <td width="7%" class="header"><div>SmartChoice Action</div></td>
		<td width="7%" class="header"><div>Product Static Price</div></td>
		<td width="7%" class="header"><div>Product Street Price</div></td>
		<td width="7%" class="header"><div>Product List Price</div></td>
		<td width="9%" class="header"><div>EPP Product Price Indication</div></td>
		<td width="9%" class="header"><div>Product Normal Price Indication</div></td>
		<td width="9%" class="header"><div>EPP Saving %</div></td>
		<td width="7%" class="header"><div>Logo</div></td>
		<td width="8%" class="header"><div>Promo Price</div></td>
		<td width="8%" class="header"><div>Promo Information</div></td>
		<td width="10%" class="header"><div>Product Reseller Name</div></td>
		<td width="7%" class="header"><div>Reseller URL</div></td>
		<td width="20%" class="header"><div>Reseller Added Value Message</div></td>
		<td width="7%" class="header"><div>Reseller Stock</div></td>
		<td width="6%" class="header"><div>Reseller Price</div></td>
      </tr>
	   <tr>
        <td></td>
        <td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
	  </thead>
	  <tbody>
	  <xsl:apply-templates/>  
	   </tbody>
   </table>

</xsl:template>
<xsl:template match="p">
	<xsl:if test="count(r/@id) = 0 ">
		<tr>
			<td class="content">
				<xsl:if test="string-length(@pn) = 0 ">
				-
				</xsl:if>
				<xsl:if test="string-length(@pn) &gt; 0 ">
				<xsl:apply-templates select="@pn"/>  
				</xsl:if> 
			</td>
			<td class="content">
				<xsl:if test="string-length(@pn) = 0 ">
				-
				</xsl:if>
				<xsl:if test="string-length(@pn) &gt; 0 ">
				<xsl:apply-templates select="@pn"/>  
				</xsl:if> 
			</td>
			<td class="content">
				<xsl:if test="string-length(@ex) = 0 ">
				-
				</xsl:if>
				<xsl:if test="string-length(@ex) &gt; 0 ">
				<xsl:apply-templates select="@ex"/>  
				</xsl:if>  
			</td>
			<td class="content">
				<xsl:if test="((string-length(@sc) = 0) or (@sc = 0))">
				-
				</xsl:if>
				<xsl:if test="string-length(@sc) &gt; 0">
				<xsl:if test="(@pt) = 1">
				Buy 
				</xsl:if>
				<xsl:if test="(@pt) = 2">
				Config 
				</xsl:if>
				<xsl:if test="(@pt) = 3">
				Buy/Config 
				</xsl:if>
			</xsl:if>
			</td>
			<td class="content">
				<xsl:if test="string-length(@sp) = 0 ">
				-
				</xsl:if>
				<xsl:if test="string-length(@sp) &gt; 0 ">
				<xsl:apply-templates select="@sp"/>  
				</xsl:if>  
			</td>
			<td class="content">
				<xsl:if test="string-length(@stp) = 0 ">
				-
				</xsl:if>
				<xsl:if test="string-length(@stp) &gt; 0 ">
				<xsl:apply-templates select="@stp"/>  
				</xsl:if>  
			</td>
			<td class="content">
				<xsl:if test="string-length(@lp) = 0 ">
				-
				</xsl:if>
				<xsl:if test="string-length(@lp) &gt; 0 ">
				<xsl:apply-templates select="@lp"/>  
				</xsl:if>  
			</td>
			<td class="content">
				<xsl:if test="string-length(@pi) = 0 ">
				-
				</xsl:if>
				<xsl:if test="string-length(@pi) &gt; 0 ">
				<xsl:apply-templates select="@pi"/>  
				</xsl:if>
			</td>
			<xsl:if test="string-length(r/@old_pr)&gt; 0 ">
				<td class="content">
					<xsl:if test="string-length(r/@old_pr) = 0 ">
					-
					</xsl:if>
					<xsl:if test="string-length(r/@old_pr) &gt; 0 ">
					<xsl:apply-templates select="r/@old_pr"/>  
					</xsl:if>
				</td>
				<td class="content">
			    		<xsl:if test="((1-((r/@pr)div(r/@old_pr)))*100)&gt; 0 ">
						<xsl:value-of select="format-number(((1-((r/@pr)div(r/@old_pr)))*100), '#,###,###.#')"/>
					</xsl:if>
					<xsl:if test="((1-((r/@pr)div(r/@old_pr)))*100)&lt; 0 ">
						<xsl:value-of select="format-number(((1-((r/@pr)div(r/@old_pr)))*100), '#,###,###.#')"/>
					</xsl:if>

					<xsl:if test="((1-((r/@pr)div(r/@old_pr)))*100)= 0 ">
						0
					</xsl:if>
				</td>
				
                        </xsl:if>
			<xsl:if test="string-length(r/@old_pr)= 0 ">
				<td class="content">
					-
				</td>
				<td class="content">
					-
				</td>
								
                        </xsl:if>
			<td class="content">
				<xsl:if test="string-length(@l) = 0 ">
				-
				</xsl:if>
				<xsl:if test="string-length(@l) &gt; 0 ">
				<xsl:apply-templates select="@l"/>  
				</xsl:if>
			</td>
			<td class="content">
				<xsl:if test="string-length(@pp) = 0 ">
				-
				</xsl:if>
				<xsl:if test="string-length(@pp) &gt; 0 ">
				<xsl:apply-templates select="@pp"/>  
				</xsl:if>
			</td>
                      <td class="content">
			   
                                <xsl:if test="count(pro) = 0">
                                 -
				</xsl:if>
				<xsl:if test="count(pro) &gt; 0 ">
				<xsl:apply-templates select="pro"/>  
				</xsl:if>
                        
				                      
		    </td>
						
			<td class="content">
			-
			</td>
			<td class="content">
			-
			</td>
			<td class="content">
			-
			</td>
			<td class="content">
			-
			</td>
			<td class="content">
			-
			</td>
		</tr>
	</xsl:if>
	<xsl:if test="count(r/@id) &gt; 0 ">
				<xsl:apply-templates select="r"/> 
	</xsl:if>
</xsl:template>

<xsl:template match="r">
	<tr>
		<td class="content">
			<xsl:if test="string-length(../@pn) = 0 ">
				-
			</xsl:if>
			<xsl:if test="string-length(../@pn) &gt; 0 ">
			<xsl:apply-templates select="../@pn"/>  
			</xsl:if>  
		</td>
		<td class="content">
			<xsl:if test="string-length(../@pn) = 0 ">
				-
			</xsl:if>
			<xsl:if test="string-length(../@pn) &gt; 0 ">
			<xsl:apply-templates select="../@pn"/>  
			</xsl:if>  
		</td>
		<td class="content">
			<xsl:choose>
				<xsl:when test= "string-length(../@ex) = 0 and string-length(@ex) = 0" >
					-
				</xsl:when>
				<xsl:when test="string-length(../@ex) &gt; 0 and string-length(@ex) &gt; 0">
					<xsl:apply-templates select="../@ex"/> / <xsl:apply-templates select="@ex"/> 
				</xsl:when>
				<xsl:when test="string-length(../@ex) &gt; 0 ">
					<xsl:apply-templates select="../@ex"/> 
				</xsl:when>
				<xsl:when test="string-length(@ex) &gt; 0">
					<xsl:apply-templates select="@ex"/> 
				</xsl:when>
			</xsl:choose>	
		</td>
		<td class="content">
				<xsl:if test="((string-length(../@sc) = 0) or ((../@sc) = 0))">
				-
				</xsl:if>
				<xsl:if test="string-length(../@sc) &gt; 0">
				<xsl:if test="(../@pt) = 1">
				Buy 
				</xsl:if>
				<xsl:if test="(../@pt) = 2">
				Config 
				</xsl:if>
				<xsl:if test="(../@pt) = 3">
				Buy/Config 
				</xsl:if>
				</xsl:if>
				
		</td>
		<td class="content">
			<xsl:if test="string-length(../@sp) = 0 ">
				-
			</xsl:if>
			<xsl:if test="string-length(../@sp) &gt; 0 ">
			<xsl:apply-templates select="../@sp"/>  
			</xsl:if> 
		</td>
		<td class="content">
			<xsl:if test="string-length(../@stp) = 0 ">
				-
			</xsl:if>
			<xsl:if test="string-length(../@stp) &gt; 0 ">
			<xsl:apply-templates select="../@stp"/>  
			</xsl:if> 
		</td>
		<td class="content">
			<xsl:if test="string-length(../@lp) = 0 ">
				-
			</xsl:if>
			<xsl:if test="string-length(../@lp) &gt; 0 ">
			<xsl:apply-templates select="../@lp"/>  
			</xsl:if> 
		</td>
		<td class="content">
			<xsl:if test="string-length(../@pi) = 0 ">
				-
			</xsl:if>
			<xsl:if test="string-length(../@pi) &gt; 0 ">
			<xsl:apply-templates select="../@pi"/>  
			</xsl:if>
		</td>
		<xsl:if test="string-length(@old_pr)&gt; 0 ">
			<td class="content">
				<xsl:if test="string-length(@old_pr) = 0 ">
				-
				</xsl:if>
				<xsl:if test="string-length(@old_pr) &gt; 0 ">
				<xsl:apply-templates select="@old_pr"/>  
				</xsl:if>
			</td>
			<td class="content">
				<xsl:if test="((1-(@pr div @old_pr))*100) = 0 ">
					0
				</xsl:if>
				<xsl:if test="((1-(@pr div @old_pr))*100) &gt; 0 ">
					<xsl:value-of select="format-number(((1-(@pr div @old_pr))*100), '#,###,###.#')" />  
				</xsl:if>
				<xsl:if test="((1-(@pr div @old_pr))*100) &lt; 0 ">
					<xsl:value-of select="format-number(((1-(@pr div @old_pr))*100), '#,###,###.#')" />  
				</xsl:if>
			</td>
			
                </xsl:if>
		<xsl:if test="string-length(@old_pr)= 0 ">
			<td class="content">
				-
			</td>
			<td class="content">
				-
			</td>
			
                </xsl:if>
		<td class="content">
			<xsl:if test="string-length(../@l) = 0 ">
				-
			</xsl:if>
			<xsl:if test="string-length(../@l) &gt; 0 ">
			<xsl:apply-templates select="../@l"/>  
			</xsl:if>
		</td>
		<td class="content">
			<xsl:if test="string-length(../@pp) = 0 ">
				-
			</xsl:if>
			<xsl:if test="string-length(../@pp) &gt; 0 ">
			<xsl:apply-templates select="../@pp"/>  
			</xsl:if>
		</td>
		<td class="content">
			   
                                <xsl:if test="count(../pro) = 0">
                                 -
				</xsl:if>
				<xsl:if test="count(../pro) &gt; 0 ">
				<xsl:apply-templates select="../pro"/>  
				</xsl:if>
                        
				                      
		</td>
		<td class="content">
		   <xsl:if test="string-length(n) = 0 ">
				-
			</xsl:if>
			<xsl:if test="string-length(n) &gt; 0 ">
			<xsl:apply-templates select="n"/>  
			</xsl:if>
	    </td>
	
	    <td class="content">
	   
		   <xsl:if test="string-length(u) = 0 ">
				-
			</xsl:if>
			<xsl:if test="string-length(u) &gt; 0 ">
			<xsl:apply-templates select="u"/>  
			</xsl:if>
	    </td>
	    <td class="content">
		   <xsl:if test="string-length(m) = 0 ">
				-
			</xsl:if>
			<xsl:if test="string-length(m) &gt; 0 ">
			<xsl:apply-templates select="m"/>  
			</xsl:if>
	    </td>
	    <td class="content">
		   <xsl:if test="string-length(@st) = 0 ">
				-
			</xsl:if>
			<xsl:if test="string-length(@st) &gt; 0 ">
			<xsl:apply-templates select="@st"/>  
			</xsl:if>
	    </td>
	    <td class="content">
	    	<xsl:if test="string-length(@pr) = 0 ">
				- 
			</xsl:if>
			<xsl:if test="string-length(@pr) &gt;  0 ">
				<xsl:if test="string-length(@hi) &gt; 0 ">
					<strike>
						<xsl:apply-templates select="@pr"/>
					</strike>
				</xsl:if>
				<xsl:if test="string-length(@hi) &lt; 1 ">
					<xsl:apply-templates select="@pr"/>
				</xsl:if>
			</xsl:if>
	    </td>
	</tr>
</xsl:template>
<xsl:template match="@pn">
  <a href="javascript:;" onclick= 'openwindow("{.}")'><xsl:value-of select="."/></a>
</xsl:template>
<xsl:template match="u">
  <a href="javascript:;" onclick= 'goto("{.}")'>Click Here</a>
</xsl:template>
<xsl:template match="pro">
<a href="#" onmouseout="hideTip()" onmouseover="showTooltip(event,'1)Promo Header,{h},2)Promo Terms,{te},3)Promo Message ,{pm},4)Promo Urgency,{ur}');return false">Yes</a>
</xsl:template>
</xsl:stylesheet>