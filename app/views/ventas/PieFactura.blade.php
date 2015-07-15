								<tr>
									<td colspan="4"><div style="height:100% !important;"></div></td>	
								</tr>
							</table>
						</div>
					</td>
				</tr>
			</tbody>
			<tfoot height="15">
				<tr>
					<td style="font-size:12px; padding-left: 116px; " colspan="2">
						<?php 
						$convertir =new Convertidor;
						echo $convertir->ConvertirALetras($total);
						?>
					</td>
					<td style="text-align:right; padding-right:15px"> Q {{f_num::get($total)}}</td>
				</tr>
			</tfoot>
		</table>	
	</div>
</div>