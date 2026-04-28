@extends('layouts.app')

@section('content')

    <x-breadcrumbs :links="[
        ['label' => 'Disclaimer'],
    ]" />

    <article class="mx-auto w-full max-w-4xl pb-24">
        <header class="mb-12 border-t-8 border-[var(--color-text-primary)] border-b-2 border-[var(--color-border)] pt-8 pb-8">
            <div class="mb-4 flex items-center gap-3">
                <span class="h-px w-8 bg-[var(--color-accent-secondary)]"></span>
                <p class="text-[10px] font-black uppercase tracking-[0.25em] text-[var(--color-accent-secondary)]">Legalitas & Informasi</p>
            </div>
            <h1 class="text-4xl font-black uppercase leading-tight tracking-tight text-[var(--color-text-primary)] md:text-6xl">Disclaimer</h1>
            <p class="mt-4 text-xs font-black tracking-widest uppercase text-[var(--color-text-secondary)] opacity-60">Pembaruan Terakhir: 21 April 2026</p>
        </header>

        <div class="static-page-prose md:text-lg">
            <h1>Disclaimer</h1>
            <p>Last updated: April 21, 2026</p>
            <h2>Interpretation and Definitions</h2>
            <h3>Interpretation</h3>
            <p>The words whose initial letters are capitalized have meanings defined under the following conditions.
                The following definitions shall have the same meaning regardless of whether they appear in singular or in plural.
            </p>
            <h3>Definitions</h3>
            <p>For the purposes of this Disclaimer:</p>
            <ul>
                <li>
                    <p><strong>Company</strong> (referred to as either &quot;the Company&quot;, &quot;We&quot;, &quot;Us&quot; or
                        &quot;Our&quot; in this Disclaimer) refers to Finlogy.</p>
                </li>
                <li>
                    <p><strong>Service</strong> refers to the Website.</p>
                </li>
                <li>
                    <p><strong>You</strong> means the individual accessing the Service, or the company, or other legal entity on
                        behalf of which such individual is accessing or using the Service, as applicable.</p>
                </li>
                <li>
                    <p><strong>Website</strong> refers to Finlogy, accessible from <a href="https://finlogy.fauzantaslim.biz.id"
                            rel="external nofollow noopener" target="_blank">https://finlogy.fauzantaslim.biz.id</a>.</p>
                </li>
            </ul>
            <h2>Disclaimer</h2>
            <p>The information contained on the Service is for general information purposes only.</p>
            <p>The Company assumes no responsibility for errors or omissions in the contents of the Service.</p>
            <p>In no event shall the Company be liable for any special, direct, indirect, consequential, or incidental damages or
                any damages whatsoever, whether in an action of contract, negligence or other tort, arising out of or in connection
                with the use of the Service or the contents of the Service. The Company reserves the right to make additions,
                deletions, or modifications to the contents on the Service at any time without prior notice. This Disclaimer has
                been created with the help of the <a href="https://www.termsfeed.com/disclaimer-generator/"
                    target="_blank">Disclaimer Generator</a>.</p>
            <p>The Company does not warrant that the Service is free of viruses or other harmful components.</p>
            <h2>External Links Disclaimer</h2>
            <p>The Service may contain links to external websites that are not provided or maintained by or in any way affiliated
                with the Company.</p>
            <p>Please note that the Company does not guarantee the accuracy, relevance, timeliness, or completeness of any
                information on these external websites.</p>
            <h2>Errors and Omissions Disclaimer</h2>
            <p>The information given by the Service is for general guidance on matters of interest only. Even if the Company takes
                every precaution to ensure that the content of the Service is both current and accurate, errors can occur. Plus,
                given the changing nature of laws, rules and regulations, there may be delays, omissions or inaccuracies in the
                information contained on the Service.</p>
            <p>The Company is not responsible for any errors or omissions, or for the results obtained from the use of this
                information.</p>
            <h2>Fair Use Disclaimer</h2>
            <p>The Company may use copyrighted material which has not always been specifically authorized by the copyright owner.
                The Company is making such material available for criticism, comment, news reporting, teaching, scholarship, or
                research.</p>
            <p>The Company believes this constitutes a &quot;fair use&quot; of any such copyrighted material as provided for in
                section 107 of the United States Copyright law (or equivalent provisions under applicable law).</p>
            <p>If You wish to use copyrighted material from the Service for your own purposes that go beyond fair use, You must
                obtain permission from the copyright owner.</p>
            <h2>Views Expressed Disclaimer</h2>
            <p>The Service may contain views and opinions which are those of the authors and do not necessarily reflect the official
                policy or position of any other author, agency, organization, employer or company, including the Company.</p>
            <p>If the Service allows users to post content (including comments), such content is the sole responsibility of the user
                who posted it. The Company is not liable for user-generated content and reserves the right to remove it for any
                reason.</p>
            <h2>No Responsibility Disclaimer</h2>
            <p>The information on the Service is provided with the understanding that the Company is not herein engaged in rendering
                legal, accounting, tax, or other professional advice and services. As such, it should not be used as a substitute
                for consultation with professional accounting, tax, legal or other competent advisers.</p>
            <p>In no event shall the Company or its suppliers be liable for any special, incidental, indirect, or consequential
                damages whatsoever arising out of or in connection with your access or use or inability to access or use the
                Service.</p>
            <h2>&quot;Use at Your Own Risk&quot; Disclaimer</h2>
            <p>All information in the Service is provided &quot;as is&quot;, with no guarantee of completeness, accuracy, timeliness
                or of the results obtained from the use of this information, and without warranty of any kind, express or implied,
                including, but not limited to warranties of performance, merchantability and fitness for a particular purpose.</p>
            <p>The Company will not be liable to You or anyone else for any decision made or action taken in reliance on the
                information given by the Service or for any consequential, special or similar damages, even if advised of the
                possibility of such damages.</p>
            <h2>Contact Us</h2>
            <p>If you have any questions about this Disclaimer, You can contact Us:</p>
            <ul>
                <li>
                    <p>By email: contact@finlogy.fauzantaslim.biz.id</p>
                </li>
                <li>
                    <p>By visiting this page on our website: <a href="https://finlogy.fauzantaslim.biz.id/kontak"
                            rel="external nofollow noopener" target="_blank">https://finlogy.fauzantaslim.biz.id/kontak</a></p>
                </li>
            </ul>
        </div>


    </article>

@endsection
