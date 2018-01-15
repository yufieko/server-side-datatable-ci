<!-- Menu -->
<div class="menu">
    <ul class="list">
        <li class="header">NAVIGASI</li>
        <?php 
        for($i=0;$i<count($menus);$i++): 
            $parent_have_child = $menus[$i]['have_child'] ? 'menu-toggle waves-effect waves-block ' : 'waves-effect waves-block ';
            $number_one = $i == 0 ? 'active' : '';
        ?>
        <li id="<?=$menus[$i]['alias']?>" class="<?=$number_one?>">
            <a href="<?=!$menus[$i]['is_link'] ? "javascript:void(0);" : dashboard_url($menus[$i]['slug'])?>" class="<?=$parent_have_child?>a-<?=$menus[$i]['alias']?>">
                <i class="material-icons"><?=$menus[$i]['icon']?></i>
                <span><?=$menus[$i]['name']?></span>
            </a>
            <?php if($menus[$i]['have_child']): ?>
            <ul class="ml-menu">
                <?php 
                $childs = $menus[$i]['childs'];
                for($j=0;$j<count($childs);$j++): 
                    $child_have_extra_child = $childs[$j]['have_child'] ? 'menu-toggle waves-effect waves-block ' : 'waves-effect waves-block ';
                ?>
                <li id="<?=$childs[$j]['alias']?>">
                    <a href="<?=!$childs[$j]['is_link'] ? "javascript:void(0);" : dashboard_url($menus[$i]['slug'].'/'.$childs[$j]['slug'])?>" class="<?=$child_have_extra_child?>a-<?=$childs[$j]['alias']?>">
                        <?=$childs[$j]['name']?>
                    </a>
                    <?php if($childs[$j]['have_child']): ?>
                    <ul class="ml-menu">
                        <?php 
                        $extra = $childs[$j]['extra_childs'];
                        for($k=0;$k<count($extra);$k++): 
                            $class = 'waves-effect waves-block a-' . $extra[$k]['alias'];
                        ?>
                        <li id="<?=$extra[$k]['alias']?>">
                            <a href="<?=empty($extra[$k]['slug']) ? dashboard_url() : dashboard_url($menus[$i]['slug'].'/'.$childs[$j]['slug'].'/'.$extra[$k]['slug'])?>" class="<?=$class?>">
                                <?=$extra[$k]['name']?>
                            </a>
                        </li>
                        <?php endfor; ?>
                    </ul>
                    <?php endif; ?>
                </li>
                <?php endfor; ?>
            </ul>
            <?php endif; ?>
        </li>
        <?php endfor; ?>
    </ul>
</div>
<!-- #Menu -->