<?php

class PageTool{
    /**
     * @param $url  分页的url
     * @param $count 总条数
     * @param $pageSize 每页多少条
     * @param $page  页码
     * @param $params array:  分页链接上的其他参数   array('name'=>'zhangsan','age'=>29)
     *                      index.php?p=Admin&c=Supplier&a=list&page=2&pageSize=4&name=zhangsan&age=29
     * @return string 分页工具条的html代码
     */
    public static function show($url, $count, $pageSize, $page, $params = array()){
        //>>1.计算分页
        $total_page = ceil($count / $pageSize); //计算总页数
        if ($page > $total_page) {
            $page = $total_page;
        }
        $prev_page = $page <= 1 ? 1 : $page - 1; //上一页
        $next_page = $page >= $total_page ? $total_page : $page + 1; //下一页
        //>>2.组织分页链接
        //>>2.1得到?后的字符串  /index.php
        if (!empty($params)) { //有参数才拼接
            $query = parse_url($url, PHP_URL_QUERY);
            $url .= empty($query) ? '?' : '&';
            //>>2.2将数组构建成url地址的参数形式
            $url .= http_build_query($params);
        }
        //拼分页下拉框的option
        $optionHtml = '';
        for ($i = 1; $i <= $total_page; ++$i) {
            $seleced = $i == $page ? 'selected' : '';
            $optionHtml .= "<option value=\"$i\" $seleced>$i</option>";
        }
        $pageHTML = <<<HTML
<table id="page-table" cellspacing="0" >
            <tbody><tr>
                <td align="right" nowrap="true">
                    <div id="turn-page">
                        总计  <span id="totalRecords">$total_page</span>页
                        页当前第 <span id="pageCurrent">$page</span>
                        页，每页 <input type="text" size="3" id="pageSize" value="$pageSize" onchange="goPage(1)">
        <span id="page-link">
          <a href="javascript:goPage(1)">第一页</a>
          <a href="javascript:goPage($prev_page)">上一页</a>
          <a href="javascript:goPage($next_page)">下一页</a>
          <a href="javascript:goPage($total_page)">最末页</a>
          <select id="gotoPage" onchange="goPage(this.value)">
                            $optionHtml
                        </select>
        </span>
                    </div>
                </td>
            </tr>
        </tbody></table>
    <script type="text/javascript">
        function goPage(page){
            var pageSize = document.getElementById('pageSize').value;
            var url = "{$url}&page="+page+"&pageSize="+pageSize;
            location.href=url;
        }
    </script>
HTML;
        return $pageHTML;
    }
} 