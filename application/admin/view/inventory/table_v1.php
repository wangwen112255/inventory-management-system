{switch name="$Think.post.looktype"}
    {case value="1"}
    <table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>仓库</th>
            <th>库存</th>
            <th>报警</th>
        </tr>
    </thead>
    <tbody>
        {volist name="inventory" id="var"}
        <tr>
            <td>{:sprintf("%06d",$var.inventory_id)}</td>
            <td>{$var.title}</td>
            <td>
                {elt name="var.quantity" value="$var.lowest"}
<span class="badge badge-important">{$var.quantity}</span>
{else/}
{$var.quantity}
{/elt}
            </td>
            <td>{$var.lowest}</td>
        </tr>
        {/volist}
    </tbody>
</table>
    {/case}
    {case value="2"}
    <table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>仓库</th>
            <th>入库</th>
            <th>单位</th>
            <th>入库日期</th>
            <th>入库人</th>
            <th>供应商</th>
        </tr>
    </thead>
    <tbody>
        {volist name="warehouse" id="var"}
        <tr>
            <td>{:sprintf("%06d",$var.id)}</td>
            <td>{$var.name}</td>
            <td>{$var.number}</td>
            <td>{$var.unit}</td>
            <td>{$var.create_time}</td>
            <td>{$var.storage_nickname}</td>
            <td>{$var.company}</td>
        </tr>
        {/volist}
    </tbody>
</table>
    {/case}
    {case value="3"}
    <table class="table table-hover table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>拨出仓库</th>
            <th>拨入仓库</th>
            <th>数量</th>
            <th>创建人</th>
            <th>时间</th>
        </tr>
    </thead>
    <tbody>
        {volist name="warehouse_allocate" id="var"}
        <tr>
            <td>{:sprintf("%06d",$var.id)}</td>
            <td>{$var.out_title}</td>
            <td>{$var.jin_title}</td>
            <td>{$var.number}</td>
            <td>{$var.nickname}</td>
            <td>{$var.create_time}</td>
        </tr>
        {/volist}
    </tbody>
</table>
    {/case}
{/switch}
