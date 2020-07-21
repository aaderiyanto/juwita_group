				<ul class="navigation navigation-main navigation-accordion">
								<!-- Main -->
								<li class="navigation-header"><span>Main Menu</span> <i class="icon-menu" title="Main pages"></i></li>
								<li class="<?php echo $this->active_menu($url_system,array("home")); ?>"><a href="<?php echo $this->base_url($config["folder_apps"]); ?>"><i class="icon-home4 text-info"></i> <span>Dashboard</span></a></li>
                                
                                <li class="<?php echo $this->active_menu($url_system,array("brand","kategori","produk","kartu_kantin","saldo_topup","harga_tiket","vendor","jenis_asset")); ?>">
									<a href="#"><i class="icon-menu2 text-danger"></i> <span>Data Master</span></a>
									<ul>
                                    	<li><a href="<?php echo $this->base_url($config["folder_apps"]); ?>brand/home"><i class="icon-list-unordered"></i> Brand Produk</a></li>
                                        <li><a href="<?php echo $this->base_url($config["folder_apps"]); ?>kategori/home"><i class="icon-list-unordered"></i> Kategori Produk</a></li>
										<li><a href="<?php echo $this->base_url($config["folder_apps"]); ?>produk/home"><i class="icon-list-unordered"></i> Produk</a></li>
                                        <li><a href="<?php echo $this->base_url($config["folder_apps"]); ?>vendor/home"><i class="icon-list-unordered"></i> Vendor</a></li>
                                        <li><a href="<?php echo $this->base_url($config["folder_apps"]); ?>jenis_asset/home"><i class="icon-list-unordered"></i> Jenis Asset</a></li>
									</ul>
								</li>
                                
                                <li class="<?php echo $this->active_menu($url_system,array("manufacturing_order")); ?>"><a href="<?php echo $this->base_url($config["folder_apps"]); ?>manufacturing_order/home"><i class="icon-archive text-success"></i> <span>Manufacturing Order</span></a></li>
                                <!--<li class="<?php echo $this->active_menu($url_system,array("manufacturing_order")); ?>">
									<a href="#"><i class="icon-archive text-success"></i> <span>Manufacturing</span></a>
									<ul>
                                    	<li><a href="<?php echo $this->base_url($config["folder_apps"]); ?>manufacturing_order/home"><i class="icon-list-unordered"></i> Manufacturing Order</a></li>
									</ul>
								</li>-->
                                
								<li class="<?php echo $this->active_menu($url_system,array("work_order")); ?>"><a href="<?php echo $this->base_url($config["folder_apps"]); ?>work_order/home"><i class="icon-cog3 text-success"></i> <span>Work Order</span></a></li>
								
                                <li class="<?php echo $this->active_menu($url_system,array("purchase_order","pembelian_stok","inventori_gudang")); ?>">
									<a href="#"><i class="icon-inbox-alt text-pink"></i> <span>Stok & Inventory</span></a>
									<ul>
                                        <li><a href="<?php echo $this->base_url($config["folder_apps"]); ?>purchase_order/home"><i class="icon-list-unordered"></i> Purchase Order (P.O)</a></li>
                                        <li><a href="<?php echo $this->base_url($config["folder_apps"]); ?>pembelian_stok/home"><i class="icon-list-unordered"></i> Transaksi Stok</a></li>
                                        <li><a href="<?php echo $this->base_url($config["folder_apps"]); ?>inventori_gudang/home"><i class="icon-list-unordered"></i> Inventori</a></li>
									</ul>
								</li>
                                
                                <li class="<?php echo $this->active_menu($url_system,array("finance_transaksi","finance_akun","transaksi_pengeluaran","transaksi_pemasukan","finance_kategori")); ?>">
									<a href="#"><i class="icon-wallet text-blue"></i> <span>Finance</span></a>
									<ul>
                                        <li><a href="<?php echo $this->base_url($config["folder_apps"]); ?>finance_akun/home"><i class="icon-list-unordered"></i> Finance Akun</a></li>
                                        <!--<li><a href="<?php echo $this->base_url($config["folder_apps"]); ?>finance_transaksi/home"><i class="icon-list-unordered"></i> Finance Transaksi</a></li>-->
                                        <li><a href="<?php echo $this->base_url($config["folder_apps"]); ?>finance_kategori/home"><i class="icon-list-unordered"></i> Finance Kategori</a></li>
                                        <!--<li><a href="<?php echo $this->base_url($config["folder_apps"]); ?>transaksi_pengeluaran/home"><i class="icon-list-unordered"></i> Transaksi Pengeluaran</a></li>
                                        <li><a href="<?php echo $this->base_url($config["folder_apps"]); ?>transaksi_pemasukan/home"><i class="icon-list-unordered"></i> Transaksi Pemasukan</a></li>-->
                                        <li><a href="<?php echo $this->base_url($config["folder_apps"]); ?>finance_transaksi/home"><i class="icon-list-unordered"></i> Finance Transaksi</a></li>
									</ul>
								</li>
								<p>&nbsp;</p>
                                
					</ul>